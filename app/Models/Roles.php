<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Roles extends Model
{
    protected $table = "roles";

    public static function getRoles(){
        return Roles::select('*')->get();
    }

    public static function get_RoleTitle($role_id){
        return Roles::select('title')
        ->where('id',$role_id)
        ->pluck('title');
    }
}
