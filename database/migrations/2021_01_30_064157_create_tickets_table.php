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
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('persons');
            $table->string('subject',30);
            $table->integer('status_id');
            $table->foreign('status_id')->references('id')->on('status');
            $table->integer('type_ticket_id');
            $table->foreign('type_ticket_id')->references('id')->on('type_ticket');
            $table->integer('priority_id');
            $table->foreign('priority_id')->references('id')->on('priority');
            $table->datetime('time', 0);
            $table->timestamp('created_at', 0);
            $table->integer('technical');
            $table->foreign('technical')->references('id')->on('persons');
            $table->text('description');
            $table->text('image');
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
