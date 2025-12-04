<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Careers extends Model
{
    protected $fillable = [
        'position',
        'slug',
        'department',
        'description',
        'requirements',
        'job_type',
        'image',
        'benefits',
        'deadline',
        'is_active'
    ];
}
