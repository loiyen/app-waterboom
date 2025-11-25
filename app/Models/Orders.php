<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    /** @use HasFactory<\Database\Factories\OrdersFactory> */
    use HasFactory;

    protected $fillable =
    [
        'customer_id',
        'order_code',
        'order_date',
        'payment_status',
        'gross'
    ];

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }

    public function items()
    {
        return $this->hasMany(Ordersitems::class);
    }

    public function serviceItem()
    {
        return $this->hasMany(Orderitemservices::class, 'orders_id');
    }
    public function transaction()
    {
        return $this->hasOne(Transactions::class);
    }
}
