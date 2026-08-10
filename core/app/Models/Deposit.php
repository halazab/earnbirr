<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = [
        'user_id', 'trx', 'amount', 'charge', 'final_amount',
        'gateway', 'method', 'information', 'reference_code',
        'status', 'admin_feedback'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 0);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 1);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 2);
    }

    public function scopeActivation($query)
    {
        return $query->where('reference_code', 'activation');
    }

    public function scopeRegular($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('reference_code')->orWhere('reference_code', '!=', 'activation');
        });
    }
}
