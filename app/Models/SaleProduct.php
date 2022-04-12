<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleProduct extends Model
{
    use HasFactory;
    protected $table ='sales_products';
    protected $fillable = ['sale_id','product_id','quantity', 'cost_price', 'cost_price_usd', 'selling_price', 'selling_price_usd', 'currency', 'created_at', 'updated_at'];
    public function product(){
        return $this->hasOne(Product::class, 'id', 'product_id') -> select(['id', 'brand_id', 'category_id', 'product']);
    }
    public function sale(){
        return $this->hasOne(Sales::class, 'id', 'sale_id') -> select(['id','client_id']);
    }
    
}