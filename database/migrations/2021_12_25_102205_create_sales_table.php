<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->string('payment_method',30);
            $table->string('payment',30);
            $table->string('delivery_method',30);
            $table->Integer('delivery_price')->nullable();
            $table->decimal('delivery_price_usd', 12,5)->nullable();
            $table->Integer('client_delivery_payment')->nullable();
            $table->decimal('client_delivery_payment_usd', 12,5)->nullable();
            $table->Integer('additional_cost')->nullable();
            $table->decimal('additional_cost_usd', 12,5)->nullable();
            $table->Integer('total_quantity');
            $table->Integer('total_amount');
            $table->decimal('total_amount_usd', 12,5); 
            $table->Integer('profit');
            $table->decimal('profit_usd', 12,5);
            $table->Integer('net_profit');
            $table->decimal('net_profit_usd', 12,5);
            $table->integer('currency');
            $table->string('additional',200)->nullable();
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
        Schema::dropIfExists('sales');
    }
}
