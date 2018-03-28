<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Role;

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
        'status',
        'validate',
        'confirmation_code',
        'position_id',
        'position_boss_id',
        'user_boss_id'
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

    public function verifyRole()
    {
        if(count($this->roles)>0)
        {
            return true;
        }

        $consejero=Role::where("name","consejero")->first();
        $this->attachRole($consejero);

        return true;
    }

    public function getCurrentRol()
    {
        $currentRoll = session('current_rol');
        if(!$currentRoll)
        {

            $currentRoll=$this->roles->first();
            if($currentRoll)
            {
                $currentRoll = $currentRoll->id;
            } 
            else 
            {
                $this->attachRole(Role::where("name","consejero")->first());
                return $this->getCurrentRol();
            }
            session(['current_rol' => $currentRoll]);
        }

        $currentRoll = Role::where("id",$currentRoll)->first();
        if(!$this->hasRole($currentRoll->name))
        {
            session(["current_rol"=>null]);
        }
        return $currentRoll;
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function position()
    {
        return $this->hasOne('App\Models\Position','id','position_id');
    }

    public function positionBoss()
    {
        return $this->hasOne('App\Models\Position','id','position_boss_id');
    }

    public function boss()
    {
        return $this->hasOne('App\User','id','user_boss_id');
    }

    public function councils()
    {
        return $this->belongsToMany('App\Models\Council','council_user')->withPivot("role_id");
    }

    public function diaries()
    {
        return $this->belongsToMany('App\Models\Diary','diary_user');
    }

    public function points()
    {
        return $this->hasMany('App\Models\Point');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }
}
