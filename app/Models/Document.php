<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
  	protected $table = 'documents';
	protected $fillable = [
		'point_id',
		'direction'
	];

	public function point()
	{
		return $this->hasOne('App\Models\Point');
	}
}
