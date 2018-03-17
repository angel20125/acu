<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Council extends Model
{
  	protected $table = 'councils';
	protected $fillable = [
		'name',
	];
}
