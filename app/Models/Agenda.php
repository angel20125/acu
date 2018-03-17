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
}
