<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model 
{
    use HasFactory;
    protected $table='sales';
    protected $fillable= ['client_id','payment_method', 'payment', 'delivery_method', 'delivery_price', 'delivery_price_usd', 'client_delivery_payment', 'client_delivery_payment_usd', 'additional_cost', 'additional_cost_usd', 'total_amount', 'total_amount_usd', 'total_quantity', 'profit', 'profit_usd', 'net_profit', 'net_profit_usd', 'currency', 'additional', 'awareness', 'created_at', 'updated_at'];
    public function saleProducts() {
        return $this->hasMany(SaleProduct::class, 'sale_id');
    }
    public function client(){
        return $this->hasOne(Client::class, 'id', 'client_id');
    }
    public function getMonthAttribute()
    {
        return date('n', strtotime($this->created_at));
    }
}