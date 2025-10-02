<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Province extends Model
{
    protected $table = 'provinces';
    public $timestamps = false;

    public static function get_province(){
        $result = Province::select('*')
        ->where('is_available',1)
        ->get();
        return $result;
    }

    public static function get_all_province(){
        $result = Province::select('*')
            ->orderby('name')
            ->get();
        return $result;
    }

    public static function update_available($id){
        $result = Province::where('id',$id)
            ->update([
                'is_available' => 1,
            ]);
        return $result;
    }
}
