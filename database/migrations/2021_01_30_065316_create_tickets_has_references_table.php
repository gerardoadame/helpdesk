<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsHasReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets_has_references', function (Blueprint $table) {
            $table->integer('tickets_id');
            $table->integer('service_id');
            $table->integer('sw_id');
            $table->integer('active_id');
            $table->foreign('tickets_id')->references('id')->on('tickets');
            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('sw_id')->references('id')->on('software');
            $table->foreign('active_id')->references('id')->on('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets_has_references');
    }
}
