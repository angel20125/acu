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

    public function councils()
    {
        return $this->belongsToMany('App\Models\Council','council_user')->withPivot("start_date","end_date");
    }

    public function meetings()
    {
        return $this->belongsToMany('App\Models\Meeting','meeting_user')->withPivot("convene","member");
    }

    public function points()
    {
        return $this->belongsToMany('App\Models\Point','point_user')->withPivot("date");
    }

    public function handle()
    {
        return $this->belongsToMany('App\Models\Meeting','meeting_agenda_user');
    }

    public function present()
    {
        return $this->belongsToMany('App\Models\Agenda','agenda_point_user');
    }
}
