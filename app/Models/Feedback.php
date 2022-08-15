<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedbacks';
    protected $guarded;

    public function client(){
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function sale(){
        return $this->hasOne(Sales::class, 'id', 'sale_id');
    }
}
