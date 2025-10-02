<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;


class Promo_banner extends Model
{
    protected $table = 'promo_banner';

    public static function get_cms(){
        $result = Promo_banner::select('promo_banner.*', 'promo_type.title AS type_name')
                ->join('promo_type','promo_banner.promo_type','=','promo_type.id')
                ->where('promo_banner.deleted_at', null)
                ->orderby('promo_banner.start_date', 'desc')
                ->orderby('promo_banner.promo_type', 'asc')
                ->get();
        return $result;
    }

    public static function searchId($id){
        $result = Promo_banner::select('*')
                ->where('id', $id)
                ->get();
        return $result;
    }

    public static function _add($promo_type, $path_banner, $created_at){
        try {
            $result = Promo_banner::insertGetId([
                'promo_type' => $promo_type,
                'path_banner' => $path_banner,
                'created_at' => $created_at,
            ]);
            return $result;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function _update($id, $promo_type, $path_banner, $updated_at){
        try {
            $result = Promo_banner::where('id', $id)
            ->update([
                'promo_type' => $promo_type,
                'path_banner' => $path_banner,
                'updated_at' => $updated_at,
            ]);
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function _delete($id){
        try {
            $result = Promo_banner::where('id', $id)
            ->update([
                 'deleted_at' => Carbon::now(),
            ]);
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function cek_irisan_promo($type_id, $start_date, $end_date, $promo_id){
        $result = Promo_banner::where('id','!=',$promo_id)
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

    public static function cek_isExist($type_id, $start_date, $end_date){
        $result = Promo_banner::where('promo_type',$type_id)
                    ->where('start_date','<=',$start_date)
                    ->where('end_date','>=',$end_date)
                    ->get();
        return $result;
    }

}
