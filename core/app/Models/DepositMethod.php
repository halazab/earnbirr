<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepositMethod extends Model
{
    protected $fillable = [
        'name', 'description', 'phone_number', 'account_name', 'user_data', 'min_amount', 'max_amount',
        'fixed_charge', 'percent_charge', 'currency', 'image', 'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
