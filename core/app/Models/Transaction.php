<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'trx', 'amount', 'charge', 'post_balance',
        'type', 'remark', 'details'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
