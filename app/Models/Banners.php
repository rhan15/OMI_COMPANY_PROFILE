<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;


class Banners extends Model
{
    protected $table = 'banners';

    public static function get_banners_cms(){
        $result = Banners::select('*')
                ->where('deleted_at', null)
                ->orderBy('seq_num', 'asc')
                ->get();
        return $result;
    }

    public static function get_banners(){
        $date_now = Carbon::now();
        $result = Banners::select('*')
                ->where('deleted_at', null)
                ->where('start_date', '<=', $date_now)
                ->where('end_date', '>=', $date_now)
                ->orderBy('seq_num', 'asc')
                ->get();
        return $result;
    }

    public static function searchId($id){
        $result = Banners::select('*')
                ->where('id', $id)
                ->get();
        return $result;
    }

    public static function _add($title, $description, $path_image, $path_thumbnail, $start_date, $end_date, $seq_num, $is_clickable,
    $is_newtab, $onclick_url, $created_by, $created_at){
        try {
            $result = Banners::insertGetId(
                ['title' => $title,
                 'description' => $description,
                 'path_image' => $path_image,
                 'path_thumbnail' => $path_thumbnail,
                 'start_date' => $start_date,
                 'end_date' => $end_date,
                 'seq_num' => $seq_num,
                 'is_clickable' => $is_clickable,
                 'is_newtab' => $is_newtab,
                 'onclick_url' => $onclick_url,
                 'created_by' => Auth::user()->id,
                //  'updated_by' => $created_by,
                //  'deleted_by' => $deleted_by,
                 'created_at' => $created_at,
                 'updated_at' => $created_at,
                //  'deleted_at' => $deleted_at
                ]
            );
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function _update($id, $title, $description, $path_image, $path_thumbnail, $start_date, $end_date, $seq_num, $is_clickable,
    $is_newtab, $onclick_url, $updated_by, $updated_at){
        try {
            $result = Banners::where('id',$id)
            ->update(
                ['title' => $title,
                 'description' => $description,
                 'path_image' => $path_image,
                 'path_thumbnail' => $path_thumbnail,
                 'start_date' => $start_date,
                 'end_date' => $end_date,
                 'seq_num' => $seq_num,
                 'is_clickable' => $is_clickable,
                 'is_newtab' => $is_newtab,
                 'onclick_url' => $onclick_url,
                 'updated_by' => Auth::user()->id,
                 'updated_at' => $updated_at,
                ]
            );
            return $result;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function _delete($id,$deleted_by){
        try {
            $result = Banners::where('id',$id)
            ->update(
                [
                 'deleted_by' => Auth::user()->id,
                 'deleted_at' => Carbon::now(),
                ]
            );
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }


}
