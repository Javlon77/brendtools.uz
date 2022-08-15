<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('sale_id')->references('id')->on('sales')->onUpdate('cascade')->onDelete('cascade');
            $table->date('sale_date');
            $table->boolean('asked')->default('0');
            $table->tinyinteger('rank')->nullable();
            $table->boolean('will_review')->default('1');
            $table->boolean('reviewed')->default('0');
            $table->boolean('reviewed_by_client')->default('1')->nullable();
            $table->string('comment', 600)->nullable();
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
        Schema::dropIfExists('feedbacks');
    }
}
