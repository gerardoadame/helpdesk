<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email',45)->unique();
            $table->string('password',60);
            $table->boolean('admin')->default(0);
            $table->timestamps();
            $table->biginteger('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('user_type');
            $table->text('avatar')->default('default.png');
            $table->biginteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('Users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
