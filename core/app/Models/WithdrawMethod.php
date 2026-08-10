<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawMethod extends Model
{
    protected $fillable = [
        'name', 'description', 'user_data', 'min_limit', 'max_limit',
        'fixed_charge', 'percent_charge', 'currency', 'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
