<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table='products';
    protected $fillable=['hasInSite','category_id','brand_id','product', 'link'];

    public function brand(){
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }
}