<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abouts extends Model
{
    protected $fillable = [
        'title',
        'content',
        'sub_content',
        'image'
    ];
}
