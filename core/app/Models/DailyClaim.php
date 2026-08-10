<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyClaim extends Model
{
    protected $fillable = ['user_id', 'claim_date', 'streak', 'reward'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
