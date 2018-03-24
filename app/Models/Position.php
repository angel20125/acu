<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
  	protected $table = 'positions';
	protected $fillable = [
		'name',
	];

    public function users()
    {
        return $this->hasMany('App\User'); //Usuarios que tienen un cargo "x"
    }
}
