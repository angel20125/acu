<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingAgendaUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_agenda_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('meeting_id')->unsigned();
            $table->integer('agenda_id')->unsigned();

            $table->foreign('meeting_id')->references('id')->on('meetings')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('agenda_id')->references('id')->on('agendas')->onUpdate('cascade')->onDelete('restrict');

            $table->primary(['user_id', 'meeting_id', 'agenda_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meeting_agenda_user');
    }
}
