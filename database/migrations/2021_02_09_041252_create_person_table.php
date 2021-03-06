<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Persons', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name');
            $table->string('last_name');
            $table->date('birth')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('employment');
            $table->biginteger('area_id')->unsigned();
            $table->foreign('area_id')->references('id')->on('Areas');
            $table->biginteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('Users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Persons');
    }
}
