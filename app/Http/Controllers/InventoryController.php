<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Branch;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::with(['branch', 'product'])->latest()->get();
        
        // Low Stock Alert
        $lowStocks = $inventories->filter(function($inv) {
            return $inv->stock_quantity <= $inv->min_stock_level;
        });

        return view('inventory.index', [
            'title' => 'Manajemen Inventaris (Stok)',
            'inventories' => $inventories,
            'lowStocks' => $lowStocks
        ]);
    }

    public function create()
    {
        // Only Superadmin or Admin can create new inventory records manually
        $branches = Auth::user()->role === 'Superadmin' ? Branch::all() : Branch::where('id', Auth::user()->branch_id)->get();
        
        return view('inventory.create', [
            'title' => 'Tambah Data Stok',
            'branches' => $branches,
            'products' => Product::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'product_id' => 'required|exists:products,id',
            'stock_quantity' => 'required|numeric|min:0',
            'min_stock_level' => 'required|numeric|min:0'
        ]);

        // Prevent duplicate inventory record for same branch and product
        if (Inventory::where('branch_id', $request->branch_id)->where('product_id', $request->product_id)->exists()) {
            return back()->withError('Data inventaris untuk produk dan cabang ini sudah ada. Silakan lakukan edit stok (Stock Opname).')->withInput();
        }

        DB::beginTransaction();
        try {
            Inventory::create($validate);
            DB::commit();
            return to_route('inventory.index')->withSuccess('Data inventaris berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('inventory.create')->withError('Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function edit(Inventory $inventory)
    {
        return view('inventory.edit', [
            'title' => 'Stock Opname / Edit Stok',
            'inventory' => $inventory,
        ]);
    }

    public function update(Request $request, Inventory $inventory)
    {
        $validate = $request->validate([
            'stock_quantity' => 'required|numeric|min:0',
            'min_stock_level' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();
        try {
            $inventory->update($validate);
            DB::commit();
            return to_route('inventory.index')->withSuccess('Stok berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('inventory.edit', $inventory)->withError('Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy(Inventory $inventory)
    {
        DB::beginTransaction();
        try {
            $inventory->delete();
            DB::commit();
            return to_route('inventory.index')->withSuccess('Data berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('inventory.index')->withError('Gagal menghapus data: ' . $e->getMessage());
        }
    }
}