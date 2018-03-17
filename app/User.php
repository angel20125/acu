<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identity_card', 
        'first_name', 
        'last_name',
        'phone_number',
        'email',
        'password',
        'authorizing',
        'allocator'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        if(!empty($value))
        {     
            $this->attributes['password'] = \Hash::make($value);
        }
    }

    public static function getCurrent()
    {
        if(Auth::check())
        {
            return Auth::user();
        }
        return false;
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }
}
