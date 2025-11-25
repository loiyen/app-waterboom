<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Places extends Model implements HasMedia
{
    use InteractsWithMedia;
    
    protected $fillable = [
        'category_place_id',
        'name',
        'slug',
        'description',
        'open',
        'close',
        'is_active',
    ];

    public function categoryplace()
    {
        return $this->belongsTo(CategoryPlaces::class, 'category_place_id');
    }

    public function registerMediaCollections(): void
    {

        $this->addMediaCollection('images')->useDisk('public');
    }
}
