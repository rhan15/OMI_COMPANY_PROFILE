<?php

namespace App\Http\Controllers\cmsomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;

use App\Models\Promo_banner;
use App\Models\Promo_type;

class promo_banner_controller extends Controller
{

    public function index(request $request){
        try{
            // $PromoBanners = Promo_banner::get_cms();
            $promo_types = Promo_type::_get();
            return view('cms-omi/promo_banner', [
                // 'banners' => $PromoBanners,
                'promo_types' => $promo_types,
            ]);
        }catch(Exception $ex){
            echo $ex->getMessage();
        }
    }

    public function add(request $request){
        try {
            $path_banner="";

            // generate nama folder untuk aws (Dengan Tipe Promo)
            $tipe_promo = \request('title');
            $words = explode(" ", $tipe_promo);
            $folder = "";

            foreach ($words as $w) {
                $folder .= $w[0];
            }

            // ======================================================================
            // cek tanggal periode promo
            // $masaberlaku = explode(" - ", \request('periode'));
            // $start_date = Carbon::createFromFormat('d/m/Y', $masaberlaku[0])->startOfDay()->addSecond(1);
            // $end_date = Carbon::createFromFormat('d/m/Y', $masaberlaku[1])->endOfDay();

            // // cek irisan tanggal promo
            // $irisan = Promo_banner::cek_irisan_promo(\request('promo_type'), $start_date, $end_date, null);
            // if ($irisan > 0) {
            //     Logs::writelogs(Auth::user()->id,'Add New Promo Banner Failed - promo multipled [try another date & time] |user='.Auth::user()->id);
            //     return response()->json([
            //         'success'=>'2',
            //         'message'=>'Periode promo tidak boleh beririsan',
            //     ]);
            // }
            // -/cek irisan tanggal promo

            // Cek gambar banner
            if ($request->hasfile('gambar_banner')) {

                // Check file extension Banner
                $fileContents = $request->file('gambar_banner');
                $imageFileType = $fileContents->getClientOriginalExtension();
                $valid_extensions = array("jpg","jpeg","png");
                if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
                    // Logs::writelogs(Auth::user()->id,'Add New Promo Banner Failed - wrong image format[use .jpg .jpeg or png image format only]|user='.Auth::user()->id);
                    return response()->json([
                        'success'=>'2',
                        'message'=>"Format gambar tidak mendukung",
                    ]);
                }
            } else {
                // Logs::writelogs(Auth::user()->id,'Add New Promo Banner Failed - wrong image format[use .jpg .jpeg or png image format only]|user='.Auth::user()->id);

                return response()->json([
                    'success'=>'2',
                    'message'=>"File gambar banner tidak terbaca",
                ]);
            }
            // ./Cek gambar banner

            // Upload Banner
            $fileContent = $request->file('gambar_banner');
            $filename = $fileContent->getClientOriginalName();
            // $fileContent->move(public_path('omi/'.$folder), $filename);
            // AWS
            Storage::disk('s3')->put('omi/Promo Banner/'.$filename, file_get_contents($fileContent));
            $path = Storage::disk('s3')->url('omi/Promo Banner/'.$filename);
            $path_banner = $path;

            $title = \request('title');
            $created_at = Carbon::now();

            $result = Promo_type::_add($title, $path_banner, $created_at);
            // $promo_id = $result;

            // Logs::writelogs(Auth::user()->id,'Add New Promo Banner Success - banner['.$promo_id.'] created|user='.Auth::user()->id);
            return response()->json([
                'success'=>'1',
                'message'=>'Berhasil menambahkan tipe promo baru',
            ]);

        } catch (Exception $ex) {
            try {
                // Logs::writelogs(Auth::user()->id,'Add New Promo Banner Failed - System Error|user='.Auth::user()->id);
            } catch (\Throwable $th) {
                //throw $th;
            }
            return response()->json([
                'success'=>'0',
                'message'=>$ex->getMessage(),
            ]);
        }
    }

    public function update(request $request){
        try {
            $path_banner="";

            // generate nama folder untuk aws (Dengan Tipe Promo)
            $tipe_promo = \request('title');
            $words = explode(" ", $tipe_promo);
            $folder = "";

            foreach ($words as $w) {
                $folder .= $w[0];
            }

            // ======================================================================
            // cek tanggal periode promo
            // $masaberlaku = explode(" - ", \request('periode'));
            // $start_date = Carbon::createFromFormat('d/m/Y', $masaberlaku[0])->startOfDay()->addSecond(1);
            // $end_date = Carbon::createFromFormat('d/m/Y', $masaberlaku[1])->endOfDay();

            // cek irisan tanggal promo
            // $irisan = Promo_banner::cek_irisan_promo(\request('promo_type'), $start_date, $end_date,\request('id'));
            // if ($irisan > 0) {
            //     Logs::writelogs(Auth::user()->id,'Update Promo Banner Failed - promo multipled [try another date & time] |user='.Auth::user()->id);
            //     return response()->json([
            //         'success'=>'2',
            //         'message'=>'Periode promo tidak boleh beririsan',
            //     ]);
            // }
            // -/cek irisan tanggal promo

            // Check file extension Banner
            $checkImageBanner = 0;
            if ($request->hasfile('gambar_banner')) {

                $fileContents = $request->file('gambar_banner');
                $imageFileType = $fileContents->getClientOriginalExtension();
                $valid_extensions = array("jpg","jpeg","png");
                if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
                    // Logs::writelogs(Auth::user()->id,'Update Promo Banner Failed - wrong image format[use .jpg .jpeg or png image format only]|user='.Auth::user()->id);
                    return response()->json([
                        'success'=>'2',
                        'message'=>"Format gambar tidak mendukung",
                    ]);
                }
                $checkImageBanner = 1;
            }
            // ./Check file extension Banner

            // Banner Decission
            // jika tidak mengirim gambar banner maka menggunakan banner lama yg sudah ada
            if ($checkImageBanner == 1) { //upload
                // Upload Banner
                $fileContent = $request->file('gambar_banner');
                $filename = $fileContent->getClientOriginalName();
                // $fileContent->move(public_path('omi/'.$folder), $filename);
                // AWS
                Storage::disk('s3')->put('omi/Promo Banner/'.$filename, file_get_contents($fileContent));
                $path = Storage::disk('s3')->url('omi/Promo Banner/'.$filename);
                $path_banner = $path;
            } else { //ambil banner lama
                $path_banner = Promo_type::searchId(\request('id'))['path_image'];
            }
            // ./Banner Decission

            $id = \request('id');
            $title = \request('title');
            // $promo_type = \request('promo_type');

            // ======================================================================
            // cek tanggal periode promo
            // $masaberlaku = explode(" - ", \request('periode'));
            // $start_date = Carbon::createFromFormat('d/m/Y', $masaberlaku[0])->startOfDay()->addSecond(1);
            // $end_date = Carbon::createFromFormat('d/m/Y', $masaberlaku[1])->endOfDay();
            $updated_at = Carbon::now();

            Promo_type::_update($id, $title, $path_banner, $updated_at);

            // Logs::writelogs(Auth::user()->id,'Update Promo Banner Success - banner['.$id.'] Updated|user='.Auth::user()->id);
            return response()->json([
                'success'=>'1',
                'message'=>'Berhasil memperbarui tipe promo',
            ]);

        } catch (Exception $ex) {
            try {
                // Logs::writelogs(Auth::user()->id,'Update Promo Banner Failed - System Error|user='.Auth::user()->id);
            } catch (\Throwable $th) {
                //throw $th;
            }
            return response()->json([
                'success'=>'0',
                'message'=>$ex->getMessage(),
            ]);
        }

    }

    public function delete(request $request){
        $id = \request('id');
        $deleted_by = null;
        $result = Promo_type::_delete($id,$deleted_by);
        if ($result == 1) {
            // Logs::writelogs(Auth::user()->id,'Delete Promo Banner Success - banner['.$id.'] Deleted|user='.Auth::user()->id);
            return response()->json([
                'success'=>'1',
                'message'=>'Berhasil menghapus tipe promo',
            ]);
        } else {
            // Logs::writelogs(Auth::user()->id,'Delete Promo Banner Failed - System Error|user='.Auth::user()->id);
            return response()->json([
                'success'=>'2',
                'message'=>$result,
            ]);
        }
    }

}
