<?php

namespace App\Http\Controllers\webomi;

use App\Models\Province;
use App\Models\Branch;
use App\Models\Shops;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ShopController extends Controller
{
    public function index(){
        $province = Province::get_province();
        $branch = Branch::get_branches(11);
        $shops = Shops::get_shops($branch[0]['id']);

        $result['province'] = $province;
        $result['branch'] = $branch;
        $result['shop'] = $shops;

        if (!empty($result)) {
            $result['status'] = 1;
        }else{
            $result['status'] = 0;
        }


        return $result;
    }

    public function get_shop_branch(request $request){
        $province_id = \request('province_id');
        $branch = Branch::get_branches($province_id);
        $result['branch'] = $branch;
        try {
            $shops = Shops::get_shops($branch[0]['id']);
            $result['shop'] = $shops;
        } catch (\Throwable $th) {
            $result['shop'] = null;
        }
        return $result;
    }

    public function get_shop_detail(request $request){
        $branch_id = \request('branch_id');
        $shops = Shops::get_shops($branch_id);
        return $result = $shops;
    }
}
