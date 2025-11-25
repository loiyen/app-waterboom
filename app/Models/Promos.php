<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promos extends Model
{
    /** @use HasFactory<\Database\Factories\PromosFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'discount_percent',
        'start_date',
        'end_date',
        'image',
        'is_active'
    ];
}
