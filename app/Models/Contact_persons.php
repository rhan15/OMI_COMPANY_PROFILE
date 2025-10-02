<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Contact_persons extends Model
{
    protected $table = 'contact_persons';
    // public $timestamps = false;

    public static function get_contact(){
        $result = Contact_persons::select('*')
        ->where('deleted_at', null)
        ->get();
        return $result;
    }
    public static function _add($area, $name, $address, $handphone, $whatsapp, $phone, $email){
        try {
            $result = Contact_persons::insertGetId( [
                'area' => $area,
                'name' => $name,
                'address' => $address,
                'handphone' => $handphone,
                'whatsapp' => $whatsapp,
                'phone' => $phone,
                'email' => $email,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
                ]
            );
            return $result;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function _update($id, $area, $name, $address, $handphone, $whatsapp, $phone, $email){
        try {
            Contact_persons::where('id',$id)->update([
                'area' => $area,
                'name' => $name,
                'address' => $address,
                'handphone' => $handphone,
                'whatsapp' => $whatsapp,
                'phone' => $phone,
                'email' => $email,
                'updated_at' => Carbon::now(),
            ]);
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function _delete($id){
        try {
            $result = Contact_persons::where('id',$id)
            ->update([
                'deleted_at' => Carbon::now(),
            ]);
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}