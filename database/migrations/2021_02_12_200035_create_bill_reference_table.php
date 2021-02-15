<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_reference', function (Blueprint $table) {
            $table->integer('bill_id');
            $table->integer('service_id');
            $table->integer('software_id');
            $table->integer('active_id');

            $table->foreign('bill_id')->references('id')->on('bills');
            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('software_id')->references('id')->on('software');
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
        Schema::dropIfExists('bill_reference');
    }
}
