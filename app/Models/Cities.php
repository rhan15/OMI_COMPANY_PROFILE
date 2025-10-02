<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Cities extends Model
{
    protected $table = 'cities';

    public static function get_cities($province_id){
        $result = Cities::select('*')
        ->where('province_id',$province_id)
        ->get();
        return $result;
    }
}
