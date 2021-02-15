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
            $table->string('subject');
            $table->timestamps(0);
            $table->time('time')->nullable();
            $table->text('description');
            $table->text('image')->nullable();
            $table->text('feedback')->nullable();
            $table->text('technical_image')->nullable();
            $table->integer('user_id');
            $table->integer('status_id');
            $table->integer('type_id');
            $table->integer('priority_id');
            $table->integer('technical_id');

            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('type_id')->references('id')->on('type_tickets');
            $table->foreign('priority_id')->references('id')->on('priorities');
            $table->foreign('technical_id')->references('id')->on('user');

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
