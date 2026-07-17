<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Expense;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Global scope applies automatically based on auth user
        $totalSales = Transaction::sum('total_amount');
        $totalExpenses = Expense::sum('amount');
        $profit = $totalSales - $totalExpenses;

        $transactionCount = Transaction::count();
        $recentTransactions = Transaction::with('customer')->latest()->take(5)->get();

        return view('dashboard.index', [
            'title' => 'Dashboard & Analitik',
            'totalSales' => $totalSales,
            'totalExpenses' => $totalExpenses,
            'profit' => $profit,
            'transactionCount' => $transactionCount,
            'recentTransactions' => $recentTransactions
        ]);
    }

    public function show()
    {
        return view('dashboard.show', [
            'title' => 'My Profile'
        ]);
    }

    public function edit()
    {
        return view('dashboard.edit', [
            'title' => 'Account Settings'
        ]);
    }

    public function update(Request $request)
    {
        // Logic for profile update if needed
    }
}