<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $guard = 'admin';
    protected $fillable = ['name', 'email', 'username', 'password', 'image'];
    protected $hidden = ['password', 'remember_token'];
}
