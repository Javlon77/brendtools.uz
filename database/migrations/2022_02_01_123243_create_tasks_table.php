<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); 
            $table->tinyinteger('user_id'); 
            $table->tinyinteger('tasker_id'); 
            $table->string('task_header', 50); 
            $table->string('task', 1000); 
            $table->boolean('status')->default('0'); 
            $table->datetime('deadline_at')->nullable(); 
            $table->datetime('done_at')->nullable(); 
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
        Schema::dropIfExists('tasks');
    }
}
