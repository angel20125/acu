<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
  	protected $table = 'meetings';
	protected $fillable = [
		'council_id', 
		'attendance', 
		'date',
		'user_id'
	];
}
