<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category.index', [
            'title' => 'Kategori Produk',
            'categories' => Category::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('category.create', [
            'title' => 'Tambah Kategori',
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ], [
            'name.required' => 'Nama kategori wajib diisi',
        ]);

        DB::beginTransaction();
        try {
            Category::create($validate);
            DB::commit();
            return to_route('category.index')->withSuccess('Data berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('category.create')->withError('Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function show(Category $category)
    {
        return view('category.show', [
            'title' => 'Detail Kategori',
            'category' => $category,
        ]);
    }

    public function edit(Category $category)
    {
        return view('category.edit', [
            'title' => 'Edit Kategori',
            'category' => $category,
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validate = $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ], [
            'name.required' => 'Nama kategori wajib diisi',
        ]);

        DB::beginTransaction();
        try {
            $category->update($validate);
            DB::commit();
            return to_route('category.index')->withSuccess('Data berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('category.edit', $category)->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }

    public function destroy(Category $category)
    {
        DB::beginTransaction();
        try {
            $category->delete();
            DB::commit();
            return to_route('category.index')->withSuccess('Data berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('category.index')->withError('Gagal menghapus data: ' . $e->getMessage());
        }
    }
}