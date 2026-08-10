<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'icon', 'image', 'status'];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
