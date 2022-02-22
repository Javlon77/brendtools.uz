<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFunnelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funnel', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->string('status',150);
            $table->string('awareness',150);
            $table->string('product',150)->nullable();
            $table->biginteger('price')->nullable();
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
        Schema::dropIfExists('funnel');
    }
}