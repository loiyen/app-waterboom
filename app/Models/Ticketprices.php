<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPrices extends Model
{
    /** @use HasFactory<\Database\Factories\TicketPricesFactory> */
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'ticket_category_id',
        'price',
        'star_date',
        'end_date'
    ];

    public function ticket()
    {
        return $this->belongsTo(Tickes::class);
    }

    public function ticket_category()
    {
        return $this->belongsTo(TicketCategories::class);
    }
}
