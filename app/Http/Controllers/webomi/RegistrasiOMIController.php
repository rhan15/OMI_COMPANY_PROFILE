<?php

namespace App\Http\Controllers\webomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Cities;
use App\Models\Districts;
use App\Models\SubDistricts;
use App\Models\Education;
use App\Models\Location;
use App\Models\Ownership;
use App\Models\Register;
use App\Models\captcha;
use Exception;

class RegistrasiOMIController extends Controller
{
    public function registrasi(request $request){
        try {
            $education = Education::get();
            $location = Location::get();
            $ownership = Ownership::get();

            return view('web-omi/registrasi', [
                'education' => $education,
                'location' => $location,
                'ownership' => $ownership,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function get_province(request $request){
        $province = Province::get_all_province();
        return $province;
    }

    public function get_city(request $request){
        $id = \request('id');
        $cities = Cities::get_cities($id);
        return $cities;
    }

    public function get_longlat(request $request){
        $city_name = \request('cityname');
        return Location::getDefaultPinLocation($city_name);
    }

    public function get_district(request $request){
        $id = \request('id');
        $districts = Districts::get_district($id);
        return $districts;
    }

    public function get_subdistrict(request $request){
        $id = \request('id');
        $subdistricts = SubDistricts::get_subdistrict($id);
        return $subdistricts;
    }

    public function get_kodepos(request $request){
        $id = \request('id');
        $kodepos = SubDistricts::get_kodepos($id);
        return $kodepos;
    }

    public function registrasi_omi(request $request){
        //get capta
        $gRecaptchaResponse = \request('capta');
        $captcha = captcha::validation($gRecaptchaResponse);
        // $captcha = captcha::validation($gRecaptchaResponse);
        if ($captcha != 1) {
            // return $captcha;
            // return redirect()->back()->withErrors(['Anda terdeteksi sebagai robot !']);
            $reg['status'] = 2;
            $reg['icon'] = 'error';
            $reg['message'] = 'Anda terdeteksi sebagai robot !';
            return $reg;
        }
        // Data Pribadi
        $name = \request('name');
        $ktp = \request('ktp');
        $jeniskelamin = \request('jenis_kelamin');
        $email =\request('email');
        $provinsi_id = \request('province_id');  //int
        $city_id = \request('city_id'); //int
        $district_id = \request('district_id'); //int
        $subdistrict_id = \request('subdistrict_id'); //int
        $address = \request('address');
        $poscode = \request('kodepos');
        $phone = \request('phone_number');
        $education = \request('education'); //int

        if ($name == null || $ktp == null || $jeniskelamin == null || $email == null ||
        $provinsi_id == 0 || $city_id == 0 || $district_id == 0 || $subdistrict_id == 0 ||
        $address == null || $poscode == null || $phone == null || $phone == 0) {
            // return redirect()->back()->with('errormessage', 'Masukkan data diri anda dengan benar !');
            // return redirect()->back()->withErrors(['Masukkan data diri anda dengan benar !']);
            $reg['status'] = 3;
            $reg['icon'] = 'error';
            $reg['message'] = 'Masukkan data diri anda dengan benar !';
            return $reg;
        }

        // Data Usulan lokasi
        $provinsi_id_loc = \request('provinsi_id_loc');  //int
        $city_id_loc = \request('city_loc'); //int
        $district_id_loc = \request('district_loc'); //int
        $subdistrict_id_loc = \request('subdistrict_loc'); //int
        $poscode_loc = \request('kodepos_loc');

        if ($provinsi_id_loc == 0 || $city_id_loc == 0 || $district_id_loc == 0 || $subdistrict_id_loc == 0) {
            // return redirect()->back()->with('errormessage', 'Lokasi usulan tidak lengkap !');
            // return redirect()->back()->withErrors(['Lokasi usulan tidak lengkap !']);
            $reg['status'] = 2;
            $reg['icon'] = 'error';
            $reg['message'] = 'Lokasi usulan tidak lengkap !';
            return $reg;
        }

        $address_loc = \request('address_loc');
        $ownership = \request('ownership');//int
        $comp_name = \request('comp_name');
        $comp_address = \request('comp_address');
        $comp_email = \request('comp_email');
        $comp_phone = \request('comp_phone');

        if ($ownership == 3 && ($comp_address == null || $comp_email == null || $comp_name == null || $comp_phone == null)) {
            // return redirect()->back()->with('errormessage', 'Identitas Badan Usaha tidak lengkap !');
            // return redirect()->back()->withErrors(['Identitas Badan Usaha tidak lengkap !']);
            $reg['status'] = 2;
            $reg['icon'] = 'error';
            $reg['message'] = 'Identitas Badan Usaha tidak lengkap !';
            return $reg;
        }

        $location_type = \request('loc_type');//int
        $length =\request('length');
        $width = \request('width');
        $floor = \request('floor');//int
        $latitude = \request('latitude');
        $longitude = \request('longitude');
        $note = \request('note');
        $checkbox = \request('setuju_box');

        if ($checkbox != 'on') {
            // return redirect()->back()->with('errormessage', 'Data ditolak : Silahkan tandai kolom persetujuan terlebih dahulu');
            // return redirect()->back()->withErrors(['Data ditolak : Silahkan tandai kolom persetujuan terlebih dahulu']);
            $reg['status'] = 2;
            $reg['icon'] = 'error';
            $reg['message'] = 'Data ditolak : Silahkan tandai kolom persetujuan terlebih dahulu !';
            return $reg;
        }


        // the code
        try {
            $result = Register::add($name, $ktp, $jeniskelamin, $email, $provinsi_id, $city_id, $district_id, $subdistrict_id,
                                $address, $poscode, $phone, $education, $provinsi_id_loc, $city_id_loc, $district_id_loc, $subdistrict_id_loc,
                                $poscode_loc, $address_loc, $ownership, $comp_name, $comp_address, $comp_email, $comp_phone,
                                $location_type, $length, $width, $floor, $latitude, $longitude, $note);
                                // return redirect()->back()->withErrors(['Pendaftaran Berhasil']);
                                $reg['status'] = 1;
                                $reg['icon'] = 'success';
                                $reg['message'] = 'Pendaftaran Berhasil';
                                return $reg;
        } catch (Exception $th) {
            $reg['icon'] = 'error';
            $reg['status'] = 2;
            $reg['message'] = $th;
            return $reg;
        }

    }
}
