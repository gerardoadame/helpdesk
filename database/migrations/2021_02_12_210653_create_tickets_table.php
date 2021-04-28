<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('subject',40);
            $table->timestamps();
            $table->dateTime('estimation')->nullable();
            $table->text('description');
            $table->text('image')->nullable();
            $table->integer('score_usr')->nullable();
            $table->integer('score_tech')->nullable();
            $table->integer('employed_id');
            $table->integer('status_id');
            $table->integer('type_id');
            $table->integer('priority_id');
            $table->integer('technical_id');


            $table->foreign('employed_id')->references('id')->on('persons');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('type_id')->references('id')->on('type_tickets');
            $table->foreign('priority_id')->references('id')->on('priorities');
            $table->foreign('technical_id')->references('id')->on('persons');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
