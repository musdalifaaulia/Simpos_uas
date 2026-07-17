<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
{
    public function index()
    {
        return view('branch.index', [
            'title' => 'Cabang',
            'branches' => Branch::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('branch.create', [
            'title' => 'Tambah Cabang',
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'address' => 'nullable',
            'phone' => 'nullable'
        ], [
            'name.required' => 'Nama cabang wajib diisi',
        ]);

        DB::beginTransaction();
        try {
            Branch::create($validate);
            DB::commit();
            return to_route('branch.index')->withSuccess('Data berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('branch.create')->withError('Gagal menambahkan data: ' . $e->getMessage());
        }
    }

    public function show(Branch $branch)
    {
        return view('branch.show', [
            'title' => 'Detail Cabang',
            'branch' => $branch,
        ]);
    }

    public function edit(Branch $branch)
    {
        return view('branch.edit', [
            'title' => 'Edit Cabang',
            'branch' => $branch,
        ]);
    }

    public function update(Request $request, Branch $branch)
    {
        $validate = $request->validate([
            'name' => 'required',
            'address' => 'nullable',
            'phone' => 'nullable'
        ], [
            'name.required' => 'Nama cabang wajib diisi',
        ]);

        DB::beginTransaction();
        try {
            $branch->update($validate);
            DB::commit();
            return to_route('branch.index')->withSuccess('Data berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('branch.edit', $branch)->withError('Gagal mengubah data: ' . $e->getMessage());
        }
    }

    public function destroy(Branch $branch)
    {
        DB::beginTransaction();
        try {
            $branch->delete();
            DB::commit();
            return to_route('branch.index')->withSuccess('Data berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('branch.index')->withError('Gagal menghapus data: ' . $e->getMessage());
        }
    }
}