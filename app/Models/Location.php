<?php

namespace App\Models;
use Carbon\Carbon;
use Storage;
use Exception;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'location_types';

    public static function get(){
        $result = Location::select('*')
            ->orderBy('created_at', 'desc')
            ->get();
        return $result;
    }

    public static function getDefaultPinLocation($city_name){
        $result['longitude'] = 106.816666;
        $result['latitude'] = -6.200000;

        $selected_city = strtoupper($city_name);
        $selected_city = str_replace(' ','',$selected_city);

        // $jsonfile = Storage::disk('local')->get('city.json');
        try {
            $jsonfile = Storage::disk('local')->get('list_location_id.json');
            $pinposition_list = json_decode($jsonfile,true);

            // foreach ($pinposition_list as $pinlist) {
            //     if (str_replace(' ','',strtoupper($pinlist['city'])) == $selected_city) {
            //         $result['longitude'] = $pinlist['lng'];
            //         $result['latitude'] = $pinlist['lat'];
            //     }
            // }

            foreach ($pinposition_list as $pinlist) {
                if (str_replace(' ','',strtoupper($pinlist['kabko'])) == $selected_city) {
                    $result['longitude'] = $pinlist['long'];
                    $result['latitude'] = $pinlist['lat'];
                }
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
        return $result;
    }
}
