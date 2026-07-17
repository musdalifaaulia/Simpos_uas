<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        return view('expense.index', [
            'title' => 'Pengeluaran Operasional',
            'expenses' => Expense::with('branch')->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('expense.create', [
            'title' => 'Catat Pengeluaran Baru'
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'expense_date' => 'required|date'
        ]);

        $validate['branch_id'] = Auth::user()->branch_id ?? 1;

        DB::beginTransaction();
        try {
            Expense::create($validate);
            DB::commit();
            return to_route('expense.index')->withSuccess('Data pengeluaran berhasil dicatat');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('expense.create')->withError('Gagal mencatat pengeluaran: ' . $e->getMessage());
        }
    }

    public function destroy(Expense $expense)
    {
        DB::beginTransaction();
        try {
            $expense->delete();
            DB::commit();
            return to_route('expense.index')->withSuccess('Data berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('expense.index')->withError('Gagal menghapus data: ' . $e->getMessage());
        }
    }
}