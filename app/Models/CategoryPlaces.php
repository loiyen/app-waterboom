<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPlaces extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryPlacesFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function place()
    {
        return $this->hasMany(Places::class, 'category_place_id');
    }

    
}
