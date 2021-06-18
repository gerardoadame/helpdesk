<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actives', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('equipment',20);
            $table->string('model',20);
            $table->text('features');
            $table->date('purchase');
            $table->date('warranty');
            $table->string('serie',45);
            $table->boolean('stock')->default(1);
            $table->integer('provider_id');
            $table->integer('payment_id');
            $table->foreign('provider_id')->references('id')->on('providers');
            $table->foreign('payment_id')->references('id')->on('payments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actives');
    }
}
