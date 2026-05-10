<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TaskImage extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'path'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

}
