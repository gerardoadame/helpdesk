<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillSupplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_supply', function (Blueprint $table) {
            $table->integer('bill_id');
            $table->integer('supply_id');
            $table->foreign('bill_id')->references('id')->on('bills');
            $table->foreign('supply_id')->references('id')->on('supplies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bill_supply');
    }
}
