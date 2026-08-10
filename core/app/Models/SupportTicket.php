<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = [
        'user_id', 'ticket_id', 'name', 'email', 'subject',
        'message', 'priority', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(SupportMessage::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 0);
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 3);
    }
}
