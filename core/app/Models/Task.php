<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'category_id', 'title', 'slug', 'description', 'instructions',
        'task_type', 'reward', 'total_slots', 'remaining_slots',
        'external_link', 'requirements', 'proof_type',
        'start_date', 'end_date', 'status', 'task_file'
    ];

    protected $casts = [
        'end_date' => 'datetime',
        'proof_type' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(TaskCategory::class, 'category_id');
    }

    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeAvailable($query)
    {
        return $query->where('tasks.status', 1)
            ->where(function ($q) {
                $q->whereNull('tasks.end_date')->orWhere('tasks.end_date', '>', now());
            })
            ->where('tasks.remaining_slots', '>', 0);
    }
}
