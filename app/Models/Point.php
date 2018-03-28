<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
  	protected $table = 'points';
	protected $fillable = [
		'diary_id',
		'user_id',
		'title',
		'description',
		'type',
		'pre_status',
		'post_status',
		'agreement'
	];

    const PRE_STATUS_INCLUIDO   = 'incluido';
    const PRE_STATUS_DESGLOSADO = 'desglosado';
    const PRE_STATUS_PROPUESTO  = 'propuesto';
    const POST_STATUS_APROBADO  = 'aprobado';
    const POST_STATUS_DIFERIDO  = 'diferido';
    const POST_STATUS_RECHAZADO = 'rechazado';

    public function diary()
    {
        return $this->belongsTo('App\Models\Diary');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function documents()
    {
        return $this->hasMany('App\Models\Document');
    }
}
