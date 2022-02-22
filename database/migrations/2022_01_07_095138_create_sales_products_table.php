<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_products', function (Blueprint $table) {
            $table->id();
            $table->Integer('sale_id');
            $table->integer('product_id');
            $table->integer('quantity');
            $table->Integer('cost_price');
            $table->decimal('cost_price_usd', 12,5);
            $table->Integer('selling_price'); 
            $table->decimal('selling_price_usd', 12,5);
            $table->integer('currency');
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_products');
    }
}
