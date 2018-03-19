<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
  	protected $table = 'agendas';
	protected $fillable = [
		'status',
		'attached_document',
		'description',
		'event_date'
	];

    // STATUS
	const STATUS_ATRATAR = 1;
	const STATUS_TRATADA = 2;

    public function points()
    {
        return $this->belongsToMany('App\Models\Point','agenda_point')->withPivot("date");
    }
}
