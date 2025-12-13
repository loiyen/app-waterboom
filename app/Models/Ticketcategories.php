<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticketcategories extends Model
{
    /** @use HasFactory<\Database\Factories\TicketCategoriesFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];
}
