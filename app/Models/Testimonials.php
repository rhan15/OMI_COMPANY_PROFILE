<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class Testimonials extends Model
{
    protected $table = 'testimonials';
    public $timestamps = false;

    public static function get_testimoni(){
        $result = Testimonials::select('*')
        ->where('deleted_at', null)
        ->get();
        return $result;
    }

    public static function _add($title, $url, $is_video, $flag_default, $description, $created_by){
        try {
            $result = Testimonials::insertGetId( [
                'title' => $title,
                'url' => $url,
                'is_video' => $is_video,
                'flag_default' => $flag_default,
                'description' => $description,
                'created_at' => Carbon::now(),
                'created_by' => Auth::user()->id,
                ]
            );
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function _update($id, $title, $url, $is_video, $flag_default, $description, $modify_by){
        try {
            Testimonials::where('id',$id)
            ->update([
                'title' => $title,
                'url' => $url,
                'is_video' => $is_video,
                'flag_default' => $flag_default,
                'description' => $description,
                'modify_at' => Carbon::now(),
                'modify_by' => Auth::user()->id,
            ]);
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function _delete($id,$deleted_by){
        try {
            $result = Testimonials::where('id',$id)
            ->update(
                [
                 'deleted_by' => $deleted_by,
                 'deleted_at' => Carbon::now(),
                ]
            );
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function searchId($id){
        $result = Testimonials::select('*')
                ->where('id', $id)
                ->get();
        return $result;
    }
}