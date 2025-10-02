<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// cms route

Route::namespace('App\Http\Controllers\cmsomi')->group(function () {

    Route::post('/export_excel', 'pendaftaran_controller@export_excel');

    // Route::post('/cms/user/register', 'user_controller@register');

    Route::get('/cms/login', function () {
        return view('cms-omi/login');
    })->name('login');
    Route::post('/cms/login_ex', 'user_controller@login');

    Route::group(['middleware' => 'auth:web'], function(){
        Route::get('/cms/user/detail', function () {
            return view('cms-omi/user_detail');
        });

        Route::get('/cms/logout', 'user_controller@logout');
        Route::get('/cms/login_status','user_controller@login_status');

        Route::get('/cms', 'dashboard_controller@index')->name('cms');

        Route::get('/cms/user', 'user_controller@index');
        Route::post('/cms/user/register', 'user_controller@register');
        Route::post('/cms/user/update', 'user_controller@update');
        Route::post('/cms/user/delete', 'user_controller@delete');
        Route::post('/cms/user/reset_password', 'user_controller@reset_password');

        Route::get('/cms/banner', 'banner_controller@index');
        Route::post('/cms/banner/searchId', 'banner_controller@searchId');
        Route::post('/cms/banner/add', 'banner_controller@add');
        Route::post('/cms/banner/update', 'banner_controller@update');
        Route::post('/cms/banner/delete', 'banner_controller@delete');

        Route::get('/cms/promoType', 'promo_banner_controller@index');
        Route::post('/cms/promoType/add', 'promo_banner_controller@add');
        Route::post('/cms/promoType/update', 'promo_banner_controller@update');
        Route::post('/cms/promoType/delete', 'promo_banner_controller@delete');

        Route::get('/cms/promosi', 'promo_controller@index');
        Route::post('/cms/promosi/add', 'promo_controller@add');
        Route::post('/cms/promosi/update', 'promo_controller@update');
        Route::post('/cms/promosi/delete', 'promo_controller@delete');

        Route::get('/cms/blog', 'blog_controller@index');
        Route::post('/cms/blog/add', 'blog_controller@add');
        Route::post('/cms/blog/update', 'blog_controller@update');
        Route::post('/cms/blog/delete', 'blog_controller@delete');

        Route::get('/cms/feedback', 'feedback_controller@index');
        Route::post('/cms/feedback/send', 'feedback_controller@send');

        Route::get('/cms/pendaftaran', 'pendaftaran_controller@index');
        Route::post('/cms/pendaftaran/send', 'pendaftaran_controller@send');

        Route::get('/cms/recipent', 'feedback_recipents_controller@index');
        Route::post('/cms/recipent/add', 'feedback_recipents_controller@add');
        Route::post('/cms/recipent/update', 'feedback_recipents_controller@update');
        Route::post('/cms/recipent/delete', 'feedback_recipents_controller@delete');

        Route::get('/cms/cabang', 'cabang_controller@index');
        Route::post('/cms/cabang/add', 'cabang_controller@add');
        Route::post('/cms/cabang/update', 'cabang_controller@update');
        Route::post('/cms/cabang/delete', 'cabang_controller@delete');

        Route::get('/cms/toko', 'toko_controller@index');
        Route::post('/cms/toko/add', 'toko_controller@add');
        Route::post('/cms/toko/update', 'toko_controller@update');
        Route::post('/cms/toko/delete', 'toko_controller@delete');

        Route::get('/cms/totalVisitor','GAnalyticsController@totalVisitor');
        Route::get('/cms/visitor','GAnalyticsController@visitor');
        Route::get('/cms/pageview','GAnalyticsController@pageview');

        Route::get('/cms/kontak_wilayah', 'kontak_controller@index');
        Route::post('/cms/kontak_wilayah/update', 'kontak_controller@update');
        Route::post('/cms/kontak_wilayah/delete', 'kontak_controller@delete');
        Route::post('/cms/kontak_wilayah/add', 'kontak_controller@add');

        Route::get('/cms/kisah_sukses', 'kisah_sukses_controller@index');
        Route::post('/cms/kisah_sukses/delete', 'kisah_sukses_controller@delete');
        Route::post('/cms/kisah_sukses/update', 'kisah_sukses_controller@update');
        Route::post('/cms/kisah_sukses/add', 'kisah_sukses_controller@add');
    });


});


// web route
Route::namespace('App\Http\Controllers\webomi')->group(function () {
    Route::get('/', 'home_web_controller@get_home');

    Route::get('/registrasi', 'RegistrasiOMIController@registrasi');
    Route::post('/registrasi_omi', 'RegistrasiOMIController@registrasi_omi');
    Route::get('/getprovince','RegistrasiOMIController@get_province');
    Route::get('/getcity/{id}','RegistrasiOMIController@get_city');
    Route::get('/getdistrict/{id}','RegistrasiOMIController@get_district');
    Route::get('/getsubdistrict/{id}','RegistrasiOMIController@get_subdistrict');
    Route::get('/getkodepos/{id}','RegistrasiOMIController@get_kodepos');
    Route::get('/getlonglat/{cityname}','RegistrasiOMIController@get_longlat');


    Route::get('/waralaba', 'waralabaController@index');
    Route::get('/berita', 'BeritaController@index'); //default
    Route::get('/berita/{page}', 'BeritaController@index'); //dgn halaman
    Route::get('/detail_berita/{id}', 'BeritaController@get_detailberita');
    Route::get('/lokasitoko', 'ShopController@index');
    Route::get('/getbranch','ShopController@get_shop_branch');
    Route::get('/getshop','ShopController@get_shop_detail');
    Route::get('/hubungi-kami', 'hubungikamiController@index');
    Route::post('/hubungi-kami/saran', 'hubungikamiController@saran');

    Route::get('/promo','PromoController@get_promo');
    Route::get('/promo/{id}','PromoController@get_promo');
    Route::get('/getbranch_promo/{id}' , 'PromoController@get_branch_promo');
    Route::post('/get_promo_images', 'PromoController@get_promo_image');
    Route::get('/tentang-kami','TentangKamiController@index');
    Route::get('/office-address','hubungikamiController@get_address');
});

Route::get('/detailberita', function () {
    return view('web-omi/detail_berita');
});
// Route::get('/promosi', function () {
//     return view('web-omi/promo');
// });
Route::get('/tes', function () {
    return bcrypt("123456");
});

// Route::get('/registrasi', function () {
//     return view('web-omi/registrasi');
// });
// Route::namespace('App\Http\Controllers\webomi')->group(function () {
//     Route::get('/', 'home_web_controller@get_home');
// }
