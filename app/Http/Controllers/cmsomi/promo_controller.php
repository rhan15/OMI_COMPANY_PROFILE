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
use App\Models\Promo_images;
use App\Models\Branch;
use App\Models\Promos;


class promo_controller extends Controller
{
    public function index(request $request){

        try{
            $promo_type = \request('promo_types');
            $branch = \request('branch_ids');

            $promos = Promos::get_cms($promo_type, $branch);
            $promo_types = Promo_type::_get();
            // $branches = Branch::get_branches_cms();

            // $provinces=[];
            // $branches_temp=[];
            // $province_id=null;
            // $province_name=null;
            // foreach ($branches as $key=>$branch) {
            //     if ($province_id == null) {
            //         $province_id = $branch['province_id'];
            //         $province_name = $branch['province_name'];
            //     } else if($province_id != $branch['province_id']) {
            //         $provinces[$province_id]= [
            //             'province_id' => $province_id,
            //             'province_name' => $province_name,
            //             'branches' => $branches_temp,
            //         ];
                
            //         $province_id = $branch['province_id'];
            //         $province_name = $branch['province_name'];
            //         $branches_temp=[];

            //     }  
            //     array_push($branches_temp, [
            //         'branch_id' => $branch['id'],
            //         'branch_name' => $branch['branch_name'],
            //     ]);
            // }

            // $provinces[$province_id]= [
            //     'province_id' => $province_id,
            //     'province_name' => $province_name,
            //     'branches' => $branches_temp,
            // ];

            for ($i=0; $i < count($promos); $i++) {
                $promo_images = Promo_images::searchId($promos[$i]['id']);
                $promos[$i]->promo_images = $promo_images;
            }

            // dd($provinces);
            return view('cms-omi/promosi', [
                'promos' => $promos,
                'promo_types' => $promo_types,
                // 'branches' => $branches,
                // 'provinces' => $provinces,
            ]);
        }catch(Exception $ex){
            echo $ex->getMessage();
        }

    }

    public function add(request $request){
        try {
            $path_katalog=[];
            // generate nama folder untuk aws (Dengan Tipe Promo)
            $tipe_promo = Promo_type::searchId(\request('promo_type'));
            $words = explode(" ", $tipe_promo['title']);
            $folder = "";

            foreach ($words as $w) {
                $folder .= $w[0];
            }

            // cek tanggal periode promo
            $masaberlaku = explode(" - ", \request('masaberlaku'));
            $start_date = Carbon::createFromFormat('d/m/Y', $masaberlaku[0])->startOfDay()->addSecond(1);
            $end_date = Carbon::createFromFormat('d/m/Y', $masaberlaku[1])->endOfDay();

            // cek irisan tanggal promo
            $irisan = Promos::cek_irisan_promo(\request('promo_type'), $start_date, $end_date, null, \request('branch_id'));

            if ($irisan > 0) {
                // Logs::writelogs(Auth::user()->id,'Add New Promo Failed - promo multipled[try another date & time]|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'3',
                    'message'=>'Periode promo tidak boleh beririsan',
                ]);
            }

            // -/cek irisan tanggal promo

            // cek banner promo is exist at period
            // $banner_isExist = Promo_banner::cek_isExist(\request('promo_type'), $start_date, $end_date);
            // if ($banner_isExist->count() == 0) {
            //     // Logs::writelogs(Auth::user()->id,'Add New Promo Failed - promo banner not found|user='.Auth::user()->id);
            //     return response()->json([
            //         'success'=>'3',
            //         'message'=>'Tidak tersedia banner pada periode terpilih <br>Silahkan tambahkan banner terlebih dahulu',
            //     ]);
            // }
            // -/cek banner promo is exist at period

            // Check file extension Katalog
            $total_katalog = \request('total_katalog');
            for ($i=0; $i < $total_katalog; $i++) {
                if ($request->hasfile('gambar_katalog'.$i)) {
                    $fileContent = $request->file('gambar_katalog'.$i);
                    $imageFileType = $fileContent->getClientOriginalExtension();
                    $valid_extensions = array("jpg","jpeg","png");
                    if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
                        // Logs::writelogs(Auth::user()->id,'Add New Promo Failed - wrong image format[use .jpg .jpeg or png image format only]|user='.Auth::user()->id);
                        return response()->json([
                            'success'=>'2',
                            'message'=>"Format gambar katalog tidak mendukung",
                        ]);
                    }
                } else {
                    // Logs::writelogs(Auth::user()->id,'Add New Promo Failed - wrong image format[use .jpg .jpeg or png image format only]|user='.Auth::user()->id);

                    return response()->json([
                        'success'=>'2',
                        'message'=>"File gambar tidak terbaca",
                    ]);
                }
            }
            // ./Check file extension Katalog

            // Upload katalog
            for ($i=0; $i < $total_katalog; $i++) {
                $fileContent = $request->file('gambar_katalog'.$i);
                $filename = $fileContent->getClientOriginalName();

                $filename = str_replace(" ","",$filename);
                
                // AWS
                Storage::disk('s3')->put('Public/comprof/Promo/'.$filename, file_get_contents($fileContent));
                $path = Storage::disk('s3')->url('Public/comprof/Promo/'.$filename);

                $path_katalog[] = $path;
            }

            $title = \request('title');
            // $branch_id = \request('branch_id');
            // $banner_id = $banner_isExist[0]['id'];
            $description = \request('description');
            $promo_type = \request('promo_type');

            $created_at = Carbon::now();

            $result = Promos::_add($title, $promo_type, $description, $start_date, $end_date, $created_at);

            $promo_id = $result;
            foreach ($path_katalog as $path_image) {
                Promo_images::_add($promo_id, $path_image, $created_at);
            }

            // Logs::writelogs(Auth::user()->id,'Add New Promo Success - promo['.$promo_id.'] created|user='.Auth::user()->id);
            return response()->json([
                'success'=>'1',
                'message'=>'Berhasil menambahkan promo baru',
            ]);

        } catch (Exception $ex) {
            try {
                // Logs::writelogs(Auth::user()->id,'Add New Promo Failed - System Error|user='.Auth::user()->id);
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
            $path_katalog=[];
            // generate nama folder untuk aws (Dengan Tipe Promo)
            $tipe_promo = Promo_type::searchId(\request('promo_type'));
            $words = explode(" ", $tipe_promo['title']);
            $folder = "";

            foreach ($words as $w) {
                $folder .= $w[0];
            }

            // ======================================================================
            // cek tanggal periode promo
            $masaberlaku = explode(" - ", \request('masaberlaku'));
            $start_date = Carbon::createFromFormat('d/m/Y', $masaberlaku[0])->startOfDay()->addSecond(1);
            $end_date = Carbon::createFromFormat('d/m/Y', $masaberlaku[1])->endOfDay();

            // cek irisan tanggal promo
            $irisan = Promos::cek_irisan_promo(\request('promo_type'), $start_date, $end_date, \request('id'), \request('branch_id'));
            if ($irisan > 0) {
                // Logs::writelogs(Auth::user()->id,'Update Promo Failed - promo multipled[try another date & time]|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'3',
                    'message'=>'Periode promo tidak boleh beririsan',
                ]);
            }
            // -/cek irisan tanggal promo

            // cek banner promo is exist at period
            // $banner_isExist = Promo_banner::cek_isExist(\request('promo_type'), $start_date, $end_date);
            // if ($banner_isExist->count() == 0) {
            //     // Logs::writelogs(Auth::user()->id,'Update Promo Failed - promo banner not found|user='.Auth::user()->id);
            //     return response()->json([
            //         'success'=>'3',
            //         'message'=>'Tidak tersedia banner pada periode terpilih <br>Silahkan tambahkan banner terlebih dahulu',
            //     ]);
            // }
            // -/cek banner promo is exist at period

            // Check file extension Katalog
            $checkImageKatalog = 0;
            $total_katalog = \request('total_katalog');
            for ($i=0; $i < $total_katalog; $i++) {
                if ($request->hasfile('gambar_katalog'.$i)) {
                    $fileContent = $request->file('gambar_katalog'.$i);
                    $imageFileType = $fileContent->getClientOriginalExtension();
                    $valid_extensions = array("jpg","jpeg","png");
                    if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
                        // Logs::writelogs(Auth::user()->id,'Update Promo Failed - wrong image format[use .jpg .jpeg or png image format only]|user='.Auth::user()->id);
                        return response()->json([
                            'success'=>'2',
                            'message'=>"Format gambar tidak mendukung",
                        ]);
                    }

                    $checkImageKatalog = 1;
                } else {
                    if ($i == 0) {
                        $checkImageKatalog = 0;
                    } else { //jika ada file yg tidak terbaca
                        // Logs::writelogs(Auth::user()->id,'Update Promo Failed - wrong image format[use .jpg .jpeg or png image format only]|user='.Auth::user()->id);
                        return response()->json([
                            'success'=>'2',
                            'message'=>"File gambar tidak terbaca",
                        ]);
                    }
                }
            }
            // ./Check file extension Katalog

            // Katalog Decission
            // jika tidak mengirim gambar katalog maka menggunakan katalog lama yg sudah ada
            if ($checkImageKatalog == 1) { //upload
                // Upload katalog
                for ($i=0; $i < $total_katalog; $i++) {
                    $fileContent = $request->file('gambar_katalog'.$i);
                    $filename = $fileContent->getClientOriginalName();
                    $filename = str_replace(" ","",$filename);

                    // AWS
                    Storage::disk('s3')->put('Public/comprof/Promo/'.$filename, file_get_contents($fileContent));
                    $path = Storage::disk('s3')->url('Public/comprof/Promo/'.$filename);

                    $path_katalog[] = $path;
                }

            } else { //ambil katalog lama
                $katalog = Promo_images::searchId(\request('id'));
                foreach ($katalog as $value) {
                    $path_katalog[] = $value['path_image'];
                }
            }
            // ./Katalog Decission

            $id = \request('id');
            $title = \request('title');
            // $branch_id = \request('branch_id');
            // $banner_id = $banner_isExist[0]['id'];
            $description = \request('description');
            $promo_type = \request('promo_type');

            $created_at = Carbon::now();

            $result = Promos::_update($id, $title, $promo_type, $description, $start_date, $end_date, $created_at);

            $promo_id = $id;
            if ($checkImageKatalog == 1) {
                Promo_images::_delete($promo_id);
                foreach ($path_katalog as $path_image) {
                    Promo_images::_add($promo_id, $path_image, $created_at);
                }
            }

            // Logs::writelogs(Auth::user()->id,'Update Promo Success - promo['.$promo_id.'] Updated|user='.Auth::user()->id);
            return response()->json([
                'success'=>'1',
                'message'=>'Berhasil memperbarui promo',
            ]);

        } catch (Exception $ex) {
            try {
                // Logs::writelogs(Auth::user()->id,'Update Promo Failed - System Error|user='.Auth::user()->id);
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
        $deleted_by = Auth::user()->id;
        $result = Promos::_delete($id,$deleted_by);
        if ($result == 1) {
            // Logs::writelogs(Auth::user()->id,'Delete Promo Success - promo['.$id.'] deleted|user='.Auth::user()->id);
            return response()->json([
                'success'=>'1',
                'message'=>'Berhasil menghapus promo',
            ]);
        } else {
            // Logs::writelogs(Auth::user()->id,'Delete Promo Failed - System Error|user='.Auth::user()->id);
            return response()->json([
                'success'=>'2',
                'message'=>$result,
            ]);
        }
    }
}
