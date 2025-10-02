<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class Shops extends Model
{
    protected $table = 'shops';
    public $timestamps = false;

    public static function get_shops($branch_id){
        $result = Shops::select('*')
            ->where('branch_id',$branch_id)
            ->get();

        return $result;
    }

    public static function get_shops_cms(){
        $result = Shops::select('shops.*', 'branches.branch_name AS branch_name')
            ->leftjoin('branches','shops.branch_id','=','branches.id')
            ->where('shops.deleted_at', null)
            // ->orderBy('seq_num', 'asc')
            ->get();
        return $result;
    }

    public static function _add($branch_id, $shop_name, $address, $longitude, $latitude){
        try {
            $result = Shops::insertGetId([
                'branch_id' => $branch_id,
                'shop_name' => $shop_name,
                'address' => $address,
                'longitude' => $longitude,
                'latitude' => $latitude,
                // 'created_by' => Auth::user()->id,
                // 'created_at' => Carbon::now(),
            ]);
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function _update($id, $branch_id, $shop_name, $address, $longitude, $latitude){
        try {
            $result = Shops::where('id',$id)
                ->update([
                    'branch_id' => $branch_id,
                    'shop_name' => $shop_name,
                    'address' => $address,
                    'longitude' => $longitude,
                    'latitude' => $latitude,
                    // 'updated_by' => Auth::user()->id,
                    // 'updated_at' => Carbon::now(),
                ]);
            return $result;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function _delete($id){
        try {
            $result = Shops::where('id',$id)
            ->update([
                // 'deleted_by' => Auth::user()->id,
                'deleted_at' => Carbon::now(),
            ]);
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
