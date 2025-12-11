<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class DashboardController extends Controller
{
    // Use constructor for middleware
    public function __construct()
    {
        // Only allow authenticated admins
        $this->middleware('auth:admins');
    }

    public function index()
    {
        // Get latest 50 transactions
        $transactions = Transaction::latest()->get();

        $data = [
            'transactions' => $transactions,
            'total_amount' => $transactions->sum(fn($t) => (float) $t->amount),
            'total_paid' => $transactions->where('status', 'paid')->sum(fn($t) => (float) $t->amount),
            'total_count' => $transactions->count(),
            'payment_method_count' => $transactions->groupBy('payment_method')->map(fn($group) => $group->count()),
        ];

        return view('dashboard', compact('data'));
    }
}
