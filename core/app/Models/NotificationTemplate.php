<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    protected $fillable = ['act', 'name', 'email_subject', 'email_body', 'sms_body', 'push_body'];
}
