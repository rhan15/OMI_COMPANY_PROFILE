<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Logs extends Model
{
    protected $table = 'user_logs';

    public static function getUserLogs(){
        return $result = Logs::select('*')->get();
    }

    public static function writelogs($user_id,$log){
        // $result = Logs::insertGetId([
        //     'user_id' => $user_id,
        //     'keterangan' => $log,
        // ]);
        // return $result;
    }
}
