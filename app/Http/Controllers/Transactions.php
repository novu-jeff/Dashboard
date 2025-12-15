<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;

class Transactions extends Controller
{
    public function index()
    {
        $search = request('search');
        $sortBy = request('sort_by', 'paid_at');
        $sortDir = request('sort_dir', 'desc');
        $perPage = request('per_page', 10);

        $transactions = Transaction::with(['account.user'])
            ->select('transactions.*')

            // Computed sortable fields
            ->selectRaw('(SELECT account_no FROM concessioner_accounts WHERE concessioner_accounts.id = transactions.account_id) AS account_no')
            ->selectRaw('(SELECT name FROM users WHERE users.id = (SELECT user_id FROM concessioner_accounts WHERE concessioner_accounts.id = transactions.account_id)) AS client_name')

            // Search
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('reference_no', 'like', "%{$search}%")
                    ->orWhereRaw('(SELECT account_no FROM concessioner_accounts WHERE concessioner_accounts.id = transactions.account_id) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('(SELECT name FROM users WHERE users.id = (SELECT user_id FROM concessioner_accounts WHERE concessioner_accounts.id = transactions.account_id)) LIKE ?', ["%{$search}%"]);
                });
            })

            // Sorting
            ->orderBy($sortBy, $sortDir)

            // Pagination
            ->paginate($perPage)
            ->appends(request()->query());

        return view('transactions.index', compact('transactions'));
    }

    public function download()
    {
        return Excel::download(new TransactionsExport, 'novustream-transactions.xlsx');
    }
}
