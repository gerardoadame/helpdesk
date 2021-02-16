<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivePersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_person', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('act_id');
            $table->integer('per_id');
            $table->date('assignment');

            $table->foreign('act_id')->references('id')->on('actives');
            $table->foreign('per_id')->references('id')->on('persons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('active_person');
    }
}
