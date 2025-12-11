<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'bill_id',
        'account_id',
        'reference_no',
        'gateway_payment_id',
        'payment_method',
        'amount',
        'fee',
        'net_amount',
        'status',
        'paid_at'
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function account()
    {
        return $this->belongsTo(ConcessionerAccount::class, 'account_id');
    }
}

