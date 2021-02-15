<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveSupplieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_supplie', function (Blueprint $table) {
            $table->integer('supplie_id');
            $table->integer('active_id');

            $table->foreign('supplie_id')->references('id')->on('supplies');
            $table->foreign('active_id')->references('id')->on('actives');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('active_supplie');
    }
}
