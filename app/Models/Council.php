<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Council extends Model
{
  	protected $table = 'councils';
	protected $fillable = [
		'name',
	];

    public function members()
    {
        return $this->belongsToMany('App\User','council_user')->withPivot("start_date","end_date");
    }
}
