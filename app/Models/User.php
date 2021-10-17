<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use \Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $arrRolesDescription = [
        "admin"  => 1,
        "user" => 6 
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login',
        'password',
        'block',
        'last_session'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function hasRole($role)
    {
        if (!auth()->check()) {
            return false;
        }

        if (!isset($this->arrRolesDescription[$role]) ) {
            return false;
        }

        $needRole = $this->arrRolesDescription[$role];
        $userid = intval(auth()->user()->id);
        $userRoles = DB::table('roles')
                    ->select('roles.id')
                    ->join('roles_for_user', 'roles.id', '=', 'roles_for_user.id_role')
                    ->where('roles_for_user.id_user', '=', $userid)
                    ->get()
                    ->toArray();
        
        $roles = [];

        foreach ($userRoles as $key => $value) {
            array_push($roles, $value->id);
        }
        //dd($roles);

        if ( in_array($needRole, $roles) ) {
            return true;
        }

        return false;
    }
}
