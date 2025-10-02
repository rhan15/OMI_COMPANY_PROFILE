<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;


class Promos extends Model
{
    protected $table = 'info_promos';

    public static function get_cms($promo_type){

        if ($promo_type != "") {
            $result = Promos::select('info_promos.*', 'promo_type.title AS promo_type_name', 'promo_type.path_image AS path_banner')
                ->leftjoin('promo_type','info_promos.promo_type','=','promo_type.id')
                ->where('info_promos.deleted_at', null)
                ->where('info_promos.promo_type', $promo_type)
                ->orderby('info_promos.created_at', 'desc')
                ->get();
            return $result;
        }else{
            $result = Promos::select('info_promos.*', 'promo_type.title AS promo_type_name', 'promo_type.path_image AS path_banner' )
                ->leftjoin('promo_type','info_promos.promo_type','=','promo_type.id')
                ->where('info_promos.deleted_at', null)
                ->orderby('info_promos.created_at', 'desc')
                ->get();
            return $result;
        }

    }

    public static function get_promo_all(){
        $result = Promos::select('info_promos.*', 'promo_type.title AS promo_type_name', 'promo_banner.path_banner AS path_banner')
        ->leftjoin('promo_type','info_promos.promo_type','=','promo_type.id')
        ->join('promo_banner','info_promos.banner_id','=','promo_banner.id')
        ->where('info_promos.start_date','<=',Carbon::now())
        ->where('info_promos.end_date','>=',Carbon::now())
        ->where('info_promos.deleted_at', null)
        ->orderby('info_promos.created_at')
        ->get();
        return $result;
    }

    public static function get_selected_promo_image($promo_type){
        $result = Promos::select('info_promos.*', 'promo_type.title AS promo_type_name', 'promo_banner.path_banner AS path_banner')
        ->leftjoin('promo_type','info_promos.promo_type','=','promo_type.id')
        ->join('promo_banner','info_promos.banner_id','=','promo_banner.id')
        ->where('info_promos.promo_type',$promo_type)
        ->where('info_promos.deleted_at', null)
        ->where('info_promos.start_date','<=',Carbon::now())
        ->where('info_promos.end_date','>=',Carbon::now())
        ->orderby('info_promos.created_at')->get();
        return $result;
    }

    public static function searchId($id){
        $result = Promos::select('*')
            ->where('id', $id)
            ->get();
        return $result;
    }

    public static function _add($title, $promo_type, $description, $start_date, $end_date, $created_at){
        try {
            $result = Promos::insertGetId([
                'title' => $title,
                'promo_type' => $promo_type,
                'description' => $description,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'created_at' => $created_at,
            ]);
            return $result;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function _update($id, $title, $promo_type, $description, $start_date, $end_date,
        $updated_at){
        try {
            $result = Promos::where('id', $id)
            ->update([
                'title' => $title,
                'promo_type' => $promo_type,
                'description' => $description,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'updated_at' => $updated_at,
            ]);
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function _delete($id){
        try {
            $result = Promos::where('id',$id)
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

    public static function cek_irisan_promo($type_id, $start_date, $end_date, $promo_id){
        $result = Promos::where('id','!=',$promo_id)
                    ->where('promo_type',$type_id)
                    ->where('deleted_at', null)
                    ->where(function($query) use ($start_date, $end_date){
                        $query->where([
                                ['start_date', '<=', $start_date],
                                ['end_date', '>=', $start_date],
                            ]);
                        $query->orwhere([
                                ['start_date', '<=', $end_date],
                                ['end_date', '>=', $end_date],
                            ]);
                    })
                    ->count();
        return $result;
    }

    public static function get_promo_type(){
        // mengambil banner tipe promo untuk halaman home dan halaman promo
        $promo_type = DB::table('promo_type')
        ->whereNull('deleted_at')
        ->get();

        return $promo_type;
    }

    public static function get_promo_by_type($promo_type_id){
        $promo = Promos::select('info_promos.*')
        ->leftjoin('promo_type','info_promos.promo_type','=','promo_type.id')
        // ->leftjoin('promo_images','info_promos.id','=','promo_images.promo_id')
        ->where('info_promos.promo_type',$promo_type_id)
        ->whereNull('info_promos.deleted_at')
        ->get();

        return $promo;
    }

    public static function get_promo_images($promo_id){
        // mengambil gambar dari promo
        $promo_type = DB::table('promo_images')
        ->where('promo_id',$promo_id)
        ->whereNull('deleted_at')
        ->get();

        return $promo_type;
    }

    public static function get_promo_id($promo_type_id){
        $result = Promos::select('info_promos.*')
                    ->where('promo_type',$promo_type_id)
                    ->where('start_date','<=',Carbon::now())
                    ->where('end_date','>=',Carbon::now())
                    ->whereNull('deleted_at')
                    ->first();

        return $result;
    }
}
