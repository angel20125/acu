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
		'date'
	];

    public function points()
    {
        return $this->belongsToMany('App\Models\Point','agenda_point')->withPivot("date");
    }
}
