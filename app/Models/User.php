<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'short_name',
        'email',
        'roles',
        'password',
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

    public static function get_email_count($email){
        return $result = User::select('*')->where('email',$email)->get();
    }

    public static function getUsers_cms($id,$roles){
        if ($roles == 1) {
            return $result = User::select('users.*','roles.title as role_name')
            ->join('roles','roles.id','users.roles')
            ->where('users.id','!=',$id)
            ->where(function($query){
                $query->where([
                        ['users.deleted_at', '0000-00-00 00:00:00'],
                    ]);
                $query->orwhere([
                        ['users.deleted_at', null],
                    ]);
            })
            ->get();
        } else {
            return $result = User::select('users.*','roles.title as role_name')
            ->join('roles','roles.id','users.roles')
            ->where('users.id','!=',$id)
            ->where(function($query){
                $query->where([
                        ['users.deleted_at', '0000-00-00 00:00:00'],
                    ]);
                $query->orwhere([
                        ['users.deleted_at', null],
                    ]);
            })
            ->where('role','>',$roles)
            ->get();
        }
    }

    public static function getCurrentEmail($id){
            return $result = User::select('*')
            ->where('id',$id)
            ->get();
    }

    public static function _update($id,$full_name, $short_name, $email, $roles){
        try {
            User::where('id',$id)->update([
                'full_name' => $full_name,
                'short_name' => $short_name,
                'email' => $email,
                'roles' => $roles,
                'updated_at' => Carbon::now(),
                'deleted_at' => '0000-00-00 00:00:00'
            ]);
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function _restore($id,$full_name, $short_name, $email, $roles){
        try {
            User::where('id',$id)->update([
                'full_name' => $full_name,
                'short_name' => $short_name,
                'email' => $email,
                'roles' => $roles,
                'updated_at' => Carbon::now(),
                'deleted_at' => '0000-00-00 00:00:00'
            ]);
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function update_password($id,$new_password){
        try {
            User::where('id',$id)->update([
                'password' => $new_password
            ]);
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function getUserRoles($id){
        $result = User::select('roles')->where('id',$id)->first();
        return $result['roles'];
    }

    public static function _delete($id){
        try {
            User::where('id',$id)->update([
                'deleted_at' => Carbon::now()
            ]);
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }

    }
}
