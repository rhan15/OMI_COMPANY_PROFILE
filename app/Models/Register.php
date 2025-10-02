<?php

namespace App\Models;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    protected $table = 'registers';

    public static function get_registers_cms(){
        $result = Register::select('registers.*', 'provinces.name AS province_name', 'cities.name AS cities_name', 'districts.name AS districts_name', 'sub_districts.name AS sub_districts_name')
            ->where('deleted_at', null)
            ->join('provinces','registers.user_province_id','=','provinces.id')
            ->join('cities','registers.user_city_id','=','cities.id')
            ->join('districts','registers.user_district_id','=','districts.id')
            ->join('sub_districts','registers.user_subdistrict_id','=','sub_districts.id')
            ->get();
        return $result;
    }

    public static function get_preview_registers_cms($start_date, $end_date){
        $result = Register::select('registers.*', 'provinces.name AS province_name', 'cities.name AS cities_name', 'districts.name AS districts_name', 'sub_districts.name AS sub_districts_name')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->where('deleted_at', null)
            ->join('provinces','registers.user_province_id','=','provinces.id')
            ->join('cities','registers.user_city_id','=','cities.id')
            ->join('districts','registers.user_district_id','=','districts.id')
            ->join('sub_districts','registers.user_subdistrict_id','=','sub_districts.id')
            ->get();
        return $result;
    }

    public static function get_registers_eksport($from_date, $to_date){
        if ($from_date == null && $to_date == null) {
            DB::statement(DB::raw('set @rownum=0'));

            $result =
                Register::select(
                    DB::raw('(@rownum:=@rownum+1) AS RowNumY'),
                    DB::raw('DATE_FORMAT(registers.created_at, "%d-%b-%Y") as register_date'),
                    'registers.user_identity',
                    'registers.user_name',
                    'registers.user_gender',
                    'registers.user_email',
                    'registers.user_phone_number',
                    // 'educations.name AS last_education',
                    'user_provinces.name AS user_province_name',
                    'user_cities.name AS user_cities_name',
                    'user_districts.name AS user_districts_name',
                    'user_sub_districts.name AS user_sub_districts_name',
                    'registers.user_postal_code AS user_postal_code',
                    'registers.user_address',
                    'loc_provinces.name AS loc_province_name',
                    'loc_cities.name AS loc_cities_name',
                    'loc_districts.name AS loc_districts_name',
                    'loc_sub_districts.name AS loc_sub_districts_name',
                    'registers.comp_name',
                    'registers.comp_address',
                    'registers.comp_phone',
                    'registers.notes'
                )
                ->where('deleted_at', null)
                // ->join('educations','registers.user_educations','=','educations.id')
                ->join('provinces as user_provinces','registers.user_province_id','=','user_provinces.id')
                ->join('cities as user_cities','registers.user_city_id','=','user_cities.id')
                ->join('districts as user_districts','registers.user_district_id','=','user_districts.id')
                ->join('sub_districts as user_sub_districts','registers.user_subdistrict_id','=','user_sub_districts.id')

                ->leftjoin('provinces as loc_provinces','registers.loc_province_id','=','loc_provinces.id')
                ->leftjoin('cities as loc_cities','registers.loc_city_id','=','loc_cities.id')
                ->leftjoin('districts as loc_districts','registers.loc_district_id','=','loc_districts.id')
                ->leftjoin('sub_districts as loc_sub_districts','registers.loc_subdistrict_id','=','loc_sub_districts.id')
                ->get();
        } else {
            DB::statement(DB::raw('set @rownum=0'));

            $result =
                Register::select(
                    DB::raw('(@rownum:=@rownum+1) AS RowNumY'),
                    DB::raw('DATE_FORMAT(registers.created_at, "%d-%b-%Y") as register_date'),
                    'registers.user_identity',
                    'registers.user_name',
                    'registers.user_gender',
                    'registers.user_email',
                    'registers.user_phone_number',
                    // 'educations.name AS last_education',
                    'user_provinces.name AS user_province_name',
                    'user_cities.name AS user_cities_name',
                    'user_districts.name AS user_districts_name',
                    'user_sub_districts.name AS user_sub_districts_name',
                    'registers.user_postal_code AS user_postal_code',
                    'registers.user_address',
                    'loc_provinces.name AS loc_province_name',
                    'loc_cities.name AS loc_cities_name',
                    'loc_districts.name AS loc_districts_name',
                    'loc_sub_districts.name AS loc_sub_districts_name',
                    'registers.comp_name',
                    'registers.comp_address',
                    'registers.comp_phone',
                    'registers.notes'
                )
                ->where('deleted_at', null)
                ->whereBetween('created_at', [$from_date, $to_date])
                // ->join('educations','registers.user_educations','=','educations.id')
                ->join('provinces as user_provinces','registers.user_province_id','=','user_provinces.id')
                ->join('cities as user_cities','registers.user_city_id','=','user_cities.id')
                ->join('districts as user_districts','registers.user_district_id','=','user_districts.id')
                ->join('sub_districts as user_sub_districts','registers.user_subdistrict_id','=','user_sub_districts.id')
    
                ->leftjoin('provinces as loc_provinces','registers.loc_province_id','=','loc_provinces.id')
                ->leftjoin('cities as loc_cities','registers.loc_city_id','=','loc_cities.id')
                ->leftjoin('districts as loc_districts','registers.loc_district_id','=','loc_districts.id')
                ->leftjoin('sub_districts as loc_sub_districts','registers.loc_subdistrict_id','=','loc_sub_districts.id')
                ->get();
        }

        return $result;
    }

    public static function add($name, $ktp, $jeniskelamin, $email, $provinsi_id, $city_id, $district_id, $subdistrict_id,
                                $address, $poscode, $phone, $education, $provinsi_id_loc, $city_id_loc, $district_id_loc, $subdistrict_id_loc,
                                $poscode_loc, $address_loc, $ownership, $comp_name, $comp_address, $comp_email, $comp_phone,
                                $location_type, $length, $width, $floor, $latitude, $longitude, $note){
        $result = Register::insertGetId([
            'user_name'=>$name,
            'user_identity'=>$ktp,
            'user_gender'=>$jeniskelamin,
            'user_email'=>$email,
            'user_province_id'=>$provinsi_id,
            'user_city_id'=>$city_id,
            'user_district_id'=>$district_id,
            'user_subdistrict_id'=>$subdistrict_id,

            'user_address'=>$address,
            'user_postal_code'=>$poscode,
            'user_phone_number'=>$phone,
            'user_educations'=>$education,
            'loc_province_id'=>$provinsi_id_loc,
            'loc_city_id'=>$city_id_loc,
            'loc_district_id'=>$district_id_loc,
            'loc_subdistrict_id'=>$subdistrict_id_loc,

            'loc_postal_code'=>$poscode_loc,
            'loc_address'=>$address_loc,
            'loc_ownership'=>$ownership,
            'comp_name'=>$comp_name,
            'comp_address'=>$comp_address,
            'comp_email'=>$comp_email,
            'comp_phone'=>$comp_phone,

            'loc_type'=>$location_type,
            'loc_long'=>$length,
            'loc_width'=>$width,
            'loc_floor'=>$floor,
            'loc_latitude'=>$latitude,
            'loc_longitude'=>$longitude,
            'notes'=>$note,

            'created_at' => Carbon::now(),
            ]);

        return $result;
    }
}
