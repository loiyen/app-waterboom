<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderitemservices extends Model
{
    /** @use HasFactory<\Database\Factories\OrderitemservicesFactory> */
    use HasFactory;

    protected $fillable = [
        'orders_id',
        'service_id',
        'qty_service',
        'price_service'
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class);
    }

    public function service()
    {
        return $this->belongsTo(Services::class);
    }
}
