<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class SubDistricts extends Model
{
    protected $table = 'sub_districts';

    public static function get_subdistrict($district_id){
        $result = SubDistricts::select('*')
        ->where('district_id',$district_id)
        ->get();
        return $result;
    }

    public static function get_kodepos($subdistrict_id){
        $result = SubDistricts::select('postcode')
        ->where('id',$subdistrict_id)
        ->pluck('postcode');
        return $result;
    }
}
