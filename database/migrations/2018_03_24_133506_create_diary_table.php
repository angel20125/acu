<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diary', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('council_id')->unsigned();
            $table->foreign('council_id')->references('id')->on('councils')->onUpdate('cascade')->onDelete('cascade');
            $table->text('description');
            $table->text('place');
            $table->integer('status')->default(0);
            $table->date('event_date');
            $table->date('limit_date');
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
        Schema::dropIfExists('diary');
    }
}
