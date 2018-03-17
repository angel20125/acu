<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('point_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('point_id')->references('id')->on('points')->onUpdate('cascade')->onDelete('restrict');
            
            $table->date('date');

            $table->primary(['user_id', 'point_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('point_user');
    }
}
