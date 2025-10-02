<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Districts extends Model
{
    protected $table = 'districts';

    public static function get_district($city_id){
        $result = Districts::select('*')
        ->where('city_id',$city_id)
        ->get();
        return $result;
    }
}
