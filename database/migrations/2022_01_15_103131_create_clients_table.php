<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('type',30);
            $table->string('name',50);
            $table->string('surname',50)->nullable();
            $table->string('gender',20);
            $table->date('dateOfBirth')->nullable();
            $table->smallinteger('company_code')->nullable();
            $table->smallinteger('master_code')->nullable();
            $table->string('phone1',13);
            $table->string('phone2',13)->nullable();
            $table->string('region',30);
            $table->string('address',100)->nullable();
            $table->string('feedback',100)->nullable();
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
        Schema::dropIfExists('clients');
    }
}