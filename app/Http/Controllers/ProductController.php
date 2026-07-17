<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index', [
            'title' => 'Katalog Produk',
            'products' => Product::with(['category', 'supplier'])->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('product.create', [
            'title' => 'Tambah Produk',
            'categories' => Category::all(),
            'suppliers' => Supplier::all()
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:products,sku',
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id'
        ], [
            'name.required' => 'Nama produk wajib diisi',
            'sku.required' => 'SKU wajib diisi',
            'sku.unique' => 'SKU ini sudah terdaftar',
            'purchase_price.required' => 'Harga beli wajib diisi',
            'selling_price.required' => 'Harga jual wajib diisi',
            'category_id.required' => 'Kategori wajib dipilih'
        ]);

        DB::beginTransaction();
        try {
            Product::create($validate);
            DB::commit();
            return to_route('product.index')->withSuccess('Data berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('product.create')->withError('Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function show(Product $product)
    {
        return view('product.show', [
            'title' => 'Detail Produk',
            'product' => $product,
        ]);
    }

    public function edit(Product $product)
    {
        return view('product.edit', [
            'title' => 'Edit Produk',
            'product' => $product,
            'categories' => Category::all(),
            'suppliers' => Supplier::all()
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validate = $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:products,sku,' . $product->id,
            'purchase_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id'
        ], [
            'name.required' => 'Nama produk wajib diisi',
            'sku.required' => 'SKU wajib diisi',
            'sku.unique' => 'SKU ini sudah terdaftar',
            'purchase_price.required' => 'Harga beli wajib diisi',
            'selling_price.required' => 'Harga jual wajib diisi',
            'category_id.required' => 'Kategori wajib dipilih'
        ]);

        DB::beginTransaction();
        try {
            $product->update($validate);
            DB::commit();
            return to_route('product.index')->withSuccess('Data berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('product.edit', $product)->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            $product->delete();
            DB::commit();
            return to_route('product.index')->withSuccess('Data berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('product.index')->withError('Gagal menghapus data: ' . $e->getMessage());
        }
    }
}