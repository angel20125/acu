<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouncilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('councils', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->integer('president_id')->unsigned()->nullable();
            $table->integer('adjunto_id')->unsigned()->nullable();

            $table->foreign('president_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('adjunto_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');

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
        Schema::dropIfExists('councils');
    }
}
