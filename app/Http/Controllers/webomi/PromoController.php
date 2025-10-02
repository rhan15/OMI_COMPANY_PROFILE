<?php

namespace App\Http\Controllers\webomi;

use App\Models\Promos;
use App\Models\Province;
use App\Models\Branch;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PromoController extends Controller
{
    public function get_promo(request $request){
        try {
            $promo_type_id = \request('id');
            $promo_type = json_decode(Promos::get_promo_type(), true);

            if (empty($promo_type_id)) {
                $promo_type_id = $promo_type[0]['id'];
            }

            $province = Province::get_province();
            $branches = Branch::get_branches_cms();

            return view('web-omi/promo', [
                'promo_type_id'=>$promo_type_id,
                'list_promo_type' =>$promo_type,
                'provinces' => $province,
                'branches' => $branches,
            ]);

        } catch (Exception $ex) {
            echo $ex->getMessage();
        }

    }

    public function get_branch_promo(request $request){
        $province_id = \request('id');
        $branch = Branch::get_branches($province_id);
        return $branch;
    }

    public function get_promo_image(request $request){
        $promo_type_id = \request('promo_type_id');
        // $branch_id = \request('branch_id');

        // $promo_info = Promos::get_promo_id($promo_type_id,$branch_id);
        $promo_info = Promos::get_promo_id($promo_type_id);
        $promo_img = json_decode(Promos::get_promo_images($promo_info['id']),true);

        $promo['info'] = $promo_info;
        $promo['img'] = $promo_img;
        $promo['promo_date'] = date('d', strtotime($promo_info['start_date'])).' - '.date('d F Y', strtotime($promo_info['end_date']));

        return $promo;
    }

}
