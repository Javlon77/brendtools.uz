<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funnel extends Model
{
    use HasFactory;
    protected $table='funnel';
    protected $fillable =['client_id','status','awareness','product','price','additional'];
}
