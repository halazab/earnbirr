<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extension extends Model
{
    protected $fillable = ['name', 'alias', 'script', 'shortcode', 'status'];

    protected $casts = [
        'shortcode' => 'object'
    ];
}
