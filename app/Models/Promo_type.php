<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;


class Promo_type extends Model
{
    protected $table = 'promo_type';

    public static function _get(){
        $result = Promo_type::select('*')
                ->where('deleted_at', null)
                ->get();
        return $result;
    }

    public static function searchId($id){
        $result = Promo_type::select('*')
                ->where('id', $id)
                ->get();
        return $result[0];
    }

    public static function _add($title, $path_banner, $created_at){
        try {
            $result = Promo_type::insertGetId([
                'title' => $title,
                'path_image' => $path_banner,
                'created_at' => $created_at,
            ]);
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function _update($id, $title, $path_image, $updated_at){
        try {
            $result = Promo_type::where('id',$id)
                ->update([
                    'title' => $title,
                    'path_image' => $path_image,
                    'updated_at' => $updated_at,
                ]);
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function _delete($id){
        try {
            $result = Promo_type::where('id',$id)
            ->update(
                [
                 'deleted_at' => Carbon::now(),
                ]
            );
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
