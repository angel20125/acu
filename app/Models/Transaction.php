<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
  	protected $table = 'transactions';
	protected $fillable = [
		'type', 
		'user_id', 
		'affected_id',
		'start_date',
		'end_date'
	];

	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
