<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordersitems extends Model
{
    /** @use HasFactory<\Database\Factories\OrdersitemsFactory> */
    use HasFactory;

    protected $fillable = [
        'orders_id',
        'ticket_id',
        'category_id',
        'qty',
        'price',

    ];

    public function order()
    {
        return $this->belongsTo(Orders::class);
    }

    public function tiket()
    {
        return $this->belongsTo(Tickes::class, 'ticket_id');
    }
    public function category_ticket()
    {
        return $this->belongsTo(TicketCategories::class, 'category_id');
    }
}
