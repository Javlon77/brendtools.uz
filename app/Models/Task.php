<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = 'tasks';
    protected $fillable = ['task_header', 'task', 'user_id', 'tasker_id', 'deadline_at'];
    protected $dates = ['deadline_at'];
}
