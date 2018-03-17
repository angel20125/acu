<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouncilUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('council_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('council_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('council_id')->references('id')->on('councils')->onUpdate('cascade')->onDelete('cascade');

            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->primary(['user_id', 'council_id','start_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('council_user');
    }
}
