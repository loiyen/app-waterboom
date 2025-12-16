<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class News extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'category_news_id',
        'title',
        'slug',
        'summary',
        'content',
        'thumbnail',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category_news()
    {
        return $this->belongsTo(Categorynews::class);
    }
}
