<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionsFactory> */
    use HasFactory;

    protected $fillable = [
        'orders_id',
        'xendit_external_id',
        'payment_type',
        'transaction_status',
        'gross_amount',
        'invoice_url',
        'expiry_time',
        'transaction_time',
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class, 'orders_id');
    }
    
}
