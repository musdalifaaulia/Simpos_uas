<?php

namespace App\Http\Controllers;

use App\Models\StockTransfer;
use App\Models\Branch;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockTransferController extends Controller
{
    public function index()
    {
        return view('stock_transfer.index', [
            'title' => 'Mutasi Stok Antar Cabang',
            'transfers' => StockTransfer::with(['product', 'fromBranch', 'toBranch', 'user'])->latest()->get(),
        ]);
    }

    public function create()
    {
        $branchId = Auth::user()->branch_id ?? 1;

        // Origin branch's inventories with available stock
        $inventories = Inventory::with('product')
                        ->where('branch_id', $branchId)
                        ->where('stock_quantity', '>', 0)
                        ->get();

        // Destination branches (excluding current branch)
        $destinationBranches = Branch::where('id', '!=', $branchId)->get();

        return view('stock_transfer.create', [
            'title' => 'Buat Mutasi Stok',
            'inventories' => $inventories,
            'destinationBranches' => $destinationBranches,
            'currentBranchId' => $branchId,
        ]);
    }

    public function store(Request $request)
    {
        $branchId = Auth::user()->branch_id ?? 1;

        $validate = $request->validate([
            'product_id' => 'required|exists:products,id',
            'to_branch_id' => 'required|exists:branches,id|different:from_branch_id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            $qtyToTransfer = (int) $request->quantity;

            // 1. Check & Reduce Source Inventory
            $sourceInventory = Inventory::where('branch_id', $branchId)
                                        ->where('product_id', $request->product_id)
                                        ->lockForUpdate()
                                        ->first();

            if (!$sourceInventory || $sourceInventory->stock_quantity < $qtyToTransfer) {
                throw new \Exception("Stok di cabang asal tidak mencukupi untuk mutasi ini.");
            }

            $sourceInventory->stock_quantity -= $qtyToTransfer;
            $sourceInventory->save();

            // 2. Increase or Create Target Inventory
            $targetInventory = Inventory::where('branch_id', $request->to_branch_id)
                                        ->where('product_id', $request->product_id)
                                        ->lockForUpdate()
                                        ->first();

            if ($targetInventory) {
                $targetInventory->stock_quantity += $qtyToTransfer;
                $targetInventory->save();
            } else {
                // Create new inventory record for the destination branch if it doesn't exist
                Inventory::create([
                    'branch_id' => $request->to_branch_id,
                    'product_id' => $request->product_id,
                    'stock_quantity' => $qtyToTransfer,
                    'min_stock_level' => 10 // Default minimum stock
                ]);
            }

            // 3. Record the Transfer
            StockTransfer::create([
                'reference_number' => 'TRF-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4)),
                'product_id' => $request->product_id,
                'from_branch_id' => $branchId,
                'to_branch_id' => $request->to_branch_id,
                'quantity' => $qtyToTransfer,
                'status' => 'Completed'
            ]);

            DB::commit();
            return to_route('stock-transfer.index')->withSuccess('Mutasi stok berhasil diproses secara otomatis.');

        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('stock-transfer.create')->withError('Gagal memproses mutasi: ' . $e->getMessage())->withInput();
        }
    }
}