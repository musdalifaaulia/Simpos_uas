<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Inventory;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index()
    {
        return view('transaction.index', [
            'title' => 'Riwayat Transaksi',
            'transactions' => Transaction::with(['customer', 'user'])->latest()->get(),
        ]);
    }

    public function create()
    {
        // POS View
        $branchId = Auth::user()->branch_id ?? 1; // Fallback for Superadmin if they don't have branch_id (or they can't sell directly without picking branch, but we assume they belong to branch 1 if testing)
        
        // Only load inventories that have stock > 0 for this branch
        $inventories = Inventory::with('product')->where('branch_id', $branchId)->where('stock_quantity', '>', 0)->get();

        return view('transaction.create', [
            'title' => 'Point of Sale (Kasir)',
            'customers' => Customer::all(),
            'inventories' => $inventories,
            'branch_id' => $branchId
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'payment_method' => 'required|string',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $branchId = Auth::user()->branch_id ?? 1;

        DB::beginTransaction();
        try {
            // Generate Invoice Number
            $invoice = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(5));
            $totalAmount = 0;

            // Prepare details and check stock
            $detailsData = [];
            foreach ($request->products as $item) {
                $qty = (int) $item['quantity'];
                $price = (float) $item['price'];
                $subtotal = $qty * $price;
                $totalAmount += $subtotal;

                // Check Inventory
                $inventory = Inventory::where('branch_id', $branchId)
                                      ->where('product_id', $item['id'])
                                      ->lockForUpdate()
                                      ->first();

                if (!$inventory || $inventory->stock_quantity < $qty) {
                    throw new \Exception("Stok tidak mencukupi untuk produk ID {$item['id']}");
                }

                // Decrease Stock
                $inventory->stock_quantity -= $qty;
                $inventory->save();

                $detailsData[] = [
                    'product_id' => $item['id'],
                    'quantity' => $qty,
                    'price_at_transaction' => $price,
                    'subtotal' => $subtotal,
                ];
            }

            // Create Transaction
            $transaction = Transaction::create([
                'invoice_number' => $invoice,
                'branch_id' => $branchId,
                'user_id' => Auth::id(),
                'customer_id' => $request->customer_id,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'status' => 'Completed',
            ]);

            // Create Details
            foreach ($detailsData as $detail) {
                $transaction->details()->create($detail);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil diproses',
                'redirect' => route('transaction.show', $transaction->id)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal: ' . $e->getMessage()
            ], 422);
        }
    }

    public function show(Transaction $transaction)
    {
        return view('transaction.show', [
            'title' => 'Detail Transaksi ' . $transaction->invoice_number,
            'transaction' => $transaction->load(['details.product', 'customer', 'user', 'branch']),
        ]);
    }
}