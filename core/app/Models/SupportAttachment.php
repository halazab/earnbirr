<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportAttachment extends Model
{
    protected $fillable = ['support_message_id', 'file'];

    public function message()
    {
        return $this->belongsTo(SupportMessage::class, 'support_message_id');
    }
}
