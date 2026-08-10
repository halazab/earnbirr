<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivation extends Model
{
    protected $fillable = ['user_id', 'trx', 'amount', 'method', 'reference_code', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
