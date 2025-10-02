<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Models\Province;


class Branch extends Model
{
    protected $table = 'branches';

    public static function get_branches($province_id){
        if (empty($province_id)||$province_id == null) {
            $province_id = 1;
        }
        $result = Branch::select('*')
        ->where('province_id',$province_id)
        ->whereNull('deleted_at')
        ->get();
        return $result;
    }

    public static function get_branches_cms(){
        $result = Branch::select('branches.*', 'provinces.id AS province_id', 'provinces.name AS province_name')
            ->leftjoin('provinces','branches.province_id','=','provinces.id')
            ->whereNull('branches.deleted_at')
            ->orderby('branches.province_id')
            ->get();
        return $result;
    }

    public static function _add($province_id, $branch_name){
        try {
            $result = Branch::insertGetId([
                'province_id' => $province_id,
                'branch_name' => $branch_name,
                // 'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);
            Province::update_available($province_id);
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function _update($id, $province_id, $branch_name){
        try {
            $result = Branch::where('id',$id)
            ->update([
                'province_id' => $province_id,
                'branch_name' => $branch_name,
                // 'created_by' => Auth::user()->id,
                // 'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);

            Province::update_available($province_id);
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function _delete($id){
        try {
            $result = Branch::where('id',$id)
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
