<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsHasReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills_has_references', function (Blueprint $table) {
            $table->integer('bill_id');
            $table->integer('serv_id');
            $table->integer('sfw_id');
            $table->integer('act_id');
            $table->foreign('bill_id')->references('id')->on('bills');
            $table->foreign('serv_id')->references('id')->on('services');
            $table->foreign('sfw_id')->references('id')->on('software');
            $table->foreign('act_id')->references('id')->on('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills_has_references');
    }
}
