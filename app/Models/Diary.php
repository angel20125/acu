<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
  	protected $table = 'diary';
	protected $fillable = [
		'description',
		'council_id',
		'place',
		'status',
		'event_date',
		'limit_date'
	];

	public function council()
	{
		return $this->belongsTo('App\Models\Council');
	}

    public function points()
    {
        return $this->hasMany('App\Models\Point');
    }

    public function diaries()
    {
        return $this->belongsToMany('App\User','diary_user');
    }
}
