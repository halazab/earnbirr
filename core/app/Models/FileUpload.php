<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    protected $fillable = ['name', 'type', 'data', 'uploadable_type', 'uploadable_id'];

    public function uploadable()
    {
        return $this->morphTo();
    }
}
