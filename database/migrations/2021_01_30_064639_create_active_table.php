<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('equipment',20);
            $table->text('features');
            $table->date('warranty');
            $table->integer('provider_id');
            $table->integer('payment_id');
            $table->integer('quantity');
            $table->foreign('provider_id')->references('id')->on('providers');
            $table->foreign('payment_id')->references('id')->on('payment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('active');
    }
}
