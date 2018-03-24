<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identity_card')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('status')->default(1);
            $table->integer('validate')->default(0);

            $table->integer('position_id')->unsigned();
            $table->foreign('position_id')->references('id')->on('positions')->onUpdate('cascade')->onDelete('restrict');

            $table->integer('position_boss_id')->unsigned()->nullable();
            $table->foreign('position_boss_id')->references('id')->on('positions')->onUpdate('cascade')->onDelete('restrict');

            $table->integer('user_boss_id')->unsigned()->nullable();
            $table->foreign('user_boss_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');

            $table->rememberToken();
            $table->timestamps();
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
