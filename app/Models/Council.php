<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Council extends Model
{
  	protected $table = 'councils';
	protected $fillable = [
		'name',
		'president_id',
		'adjunto_id'
	];

	public function president()
	{
		return $this->hasOne('App\User','id','president_id');
	}

	public function adjunto()
	{
		return $this->hasOne('App\User','id','adjunto_id');
	}

    public function users()
    {
        return $this->belongsToMany('App\User','council_user')->withPivot("role_id");;
    }

    public function diaries()
    {
        return $this->hasMany('App\Models\Diary');
    }
}
