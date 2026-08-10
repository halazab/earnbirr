<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['name', 'slug', 'sections', 'seo_content', 'status'];

    protected $casts = [
        'sections' => 'array',
        'seo_content' => 'object'
    ];
}
