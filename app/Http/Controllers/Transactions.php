<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;

class Transactions extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['bill', 'account'])
            ->orderBy('paid_at', 'desc')
            ->paginate(20);

        return view('transactions.index', compact('transactions'));
    }

    public function download()
    {
        return Excel::download(new TransactionsExport, 'novustream-transactions.xlsx');
    }
}
