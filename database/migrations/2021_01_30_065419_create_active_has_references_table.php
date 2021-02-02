<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveHasReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_has_references', function (Blueprint $table) {
            $table->integer('active_id');
            $table->integer('persons_id');
            $table->date('assignment');
            $table->foreign('active_id')->references('id')->on('active');
            $table->foreign('persons_id')->references('id')->on('persons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('active_has_references');
    }
}
