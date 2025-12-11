<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Transaction::with(['account.user'])
            ->orderBy('paid_at', 'desc')
            ->get()
            ->map(function ($t) {
                return [
                    'Reference No' => $t->reference_no,
                    'Account No'   => $t->account->account_no ?? 'N/A',
                    'Client Name'  => $t->account->user->name ?? 'N/A',
                    'Amount'       => $t->amount,
                    'Fee'          => $t->fee,
                    'Net Amount'   => $t->net_amount,
                    'Gateway'      => strtoupper($t->payment_method),
                    'Paid At'      => optional($t->paid_at)->format('M d, Y h:i A'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Reference No',
            'Account No',
            'Client Name',
            'Amount',
            'Fee',
            'Net Amount',
            'Gateway',
            'Paid Date',
        ];
    }
}
