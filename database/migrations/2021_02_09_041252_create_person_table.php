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
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('age',3)->nullable();
            $table->string('address');
            $table->string('phone');
            $table->string('employment');
            $table->biginteger('user_id')->unsigned();;
            $table->foreign('user_id')->references('id')->on('Users');
            $table->biginteger('area_id')->unsigned();;
            $table->foreign('area_id')->references('id')->on('Areas');
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
