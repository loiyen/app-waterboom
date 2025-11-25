<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickes extends Model
{
    /** @use HasFactory<\Database\Factories\TickesFactory> */
    use HasFactory;

    protected $fillable = [
        'ticket_name',
        'description',
    ];

    public function category_ticket()
    {
        return $this->belongsTo(TicketCategories::class);
    }
}
