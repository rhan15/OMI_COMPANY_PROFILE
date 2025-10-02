<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;


class Promo_images extends Model
{
    protected $table = 'promo_images';

    public static function get_all_promoimages(){
        $result = Promo_images::select('*')
                ->where('deleted_at', null)
                ->orderBy('promo_id', 'asc')
                ->get();
        return $result;
    }

    public static function get_selected_bigimages($banner_id){
        $result = Promo_images::select('*')
                ->where('promo_id', $banner_id)
                ->where('deleted_at',null)
                ->get();
        return $result;
    }

    public static function searchId($id){
        $result = Promo_images::select('*')
                ->where('promo_id', $id)
                ->get();
        return $result;
    }

    public static function _add($promo_id, $path_image, $created_at){
        try {
            $result = Promo_images::insertGetId([
                'promo_id' => $promo_id,
                'path_image' => $path_image,
                'created_at' => $created_at,
            ]);
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function _update($id, $promo_id, $path_image, $updated_at){
        try {
            $result = Promo_images::where('id',$id)
            ->update([
                'promo_id' => $promo_id,
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
            $result = Promo_images::where('promo_id',$id)
            ->delete();
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
