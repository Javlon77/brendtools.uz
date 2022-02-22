<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasFactory;
    protected $table = 'costs';
    protected $fillable = ['reason', 'category_id', 'additional', 'cost', 'cost_usd', 'currency'];

    public function getMonthAttribute()
    {
        return date('m', strtotime($this->created_at));
    }
}
