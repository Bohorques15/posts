<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','birthdate','country',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getCurrent(){
        if(Auth::check()){
            return Auth::user();
        }

        return false;
    }

    public function getCurrentRol(){
        $roles = $this->getRoleNames();
        
        if(count($roles) < 1){
            return false;
        }

        $role = Role::findByName($roles[0]);

        return $role;
    }

    public function posts(){
        return $this->hasMany('App\Models\Post');
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }
}
