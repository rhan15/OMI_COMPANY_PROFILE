<?php

namespace App\Http\Controllers\webomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;

use App\Models\Banners;
use App\Models\Products;
use App\Models\Blogs;
use App\Models\Promos;
use App\Models\Testimonials;

class home_web_controller extends Controller
{
    public function get_home(request $request){
        // return date('Y-m-d H:i:s');

        try{
            $banners = Banners::get_banners();
            // $products = Products::get_products();
            $blogs = Blogs::get_blogs(1);
            $promo_type = Promos::get_promo_type();
            $Testimonials = Testimonials::get_testimoni();

            return view('web-omi/home', [
                'banners' => $banners,
                // 'products' => $products,
                'blogs' => $blogs['blogs'],
                'promo_type' => json_decode($promo_type, true),
                'Testimonials' => $Testimonials,
            ]);
        }catch(Exception $ex){
            echo $ex->getMessage();
        }

    }

    public function getAnalyticsSummary(Request $request){
        $client = // Read Hello Analytics Tutorial for details.

        // Return results as objects.
        $client->setUseObjects(true);

        $analytics = new apiAnalyticsService($client);
    }
}
