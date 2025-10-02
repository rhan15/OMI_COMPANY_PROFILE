<?php

namespace App\Http\Controllers\cmsomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;

use App\Models\Banners;


class banner_controller extends Controller
{
    public function index(request $request){
        try{
            $banners = Banners::get_banners_cms();

            return view('cms-omi/banner',[
                'banners' => $banners,
            ]);

        }catch(Exception $ex){
            echo $ex->getMessage();
        }
    }

    public function add(request $request){
        try {
            $filename="";
            if ($request->hasfile('gambar')) {
                $fileContents = $request->file('gambar');
                $imageFileType = $fileContents->getClientOriginalExtension();

                $filename = $fileContents->getClientOriginalName();

                /* Check file extension */
                $valid_extensions = array("jpg","jpeg","png");
                if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
                    // Logs::writelogs(Auth::user()->id,'Add New Banner Failed - wrong image format[use .jpg .jpeg or png image format only]|user='.Auth::user()->id);
                    return response()->json([
                        'success'=>'3',
                        'message'=>"Format gambar tidak mendukung",
                    ]);
                }

                /* Check image dimension */
                $imagesize = getimagesize($fileContents);
                $imageWidth = $imagesize[0];
                $imageHeight = $imagesize[1];

                $imageDimension = $imageHeight/$imageWidth;
                if ($imageDimension < 0.3 || $imageDimension > 0.4) { //tidak sesuai
                    // Logs::writelogs(Auth::user()->id,'Add New Banner Failed - wrong image format[image ratio must 3:1]|user='.Auth::user()->id);

                    return response()->json([
                        'success'=>'3',
                        'message'=>"Ukuran dimensi hanya mendukung 3:1",
                    ]);
                }

                // Save Image
                // public local
                // $request->file('gambar')->move(public_path('Banner'), $filename);



                // AWS
                Storage::disk('s3')->put('omi/Banner/'.$filename, file_get_contents($fileContents));
                $path = Storage::disk('s3')->url('omi/Banner/'.$filename);



                // Storage::disk('public')->put('Banner'.$filename, $fileContents);
                // $path = Storage::disk('public')->put('Banner', $fileContents);
                // $path = '';
                // return response()->json([
                //     'success'=>'2',
                //     'message'=>$path,
                // ]);

            } else {
                // Logs::writelogs(Auth::user()->id,'Add New Banner Failed - wrong image format[use .jpg .jpeg or png image format only]|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'2',
                    'message'=>"File gambar tidak terbaca",
                ]);
            }

            $title = \request('title');
            $description = \request('description');
            $path_image = $path;
            $path_thumbnail = $path;

            $masaberlaku = explode(" - ", \request('masaberlaku'));
            $start_date = Carbon::createFromFormat('d/m/Y', $masaberlaku[0])->startOfDay()->addSecond(1);
            $end_date = Carbon::createFromFormat('d/m/Y', $masaberlaku[1])->endOfDay();

            $onclick_url = \request('tautan');
            $seq_num = \request('seq_num');
            $is_clickable = isset($onclick_url) ? '1' : '0';
            $is_newtab = \request('isnewtab');
            $created_by = null;
            $created_at = Carbon::now();

            $result = Banners::_add($title, $description, $path_image, $path_thumbnail, $start_date, $end_date, $seq_num, $is_clickable,
            $is_newtab, $onclick_url, $created_by, $created_at);

            if ($result == 1) {
                // Logs::writelogs(Auth::user()->id,'Add New Banner Success - banner'.$title.' created|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'1',
                    'message'=>'Berhasil menambahkan banner baru',
                ]);
            } else {
                // Logs::writelogs(Auth::user()->id,'Add New Banner Failed - System Error|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'2',
                    'message'=>$result,
                ]);
            }

        } catch (Exception $ex) {
            return response()->json([
                'success'=>'0',
                'message'=>$ex->getMessage(),
            ]);
        }

    }

    public function update(request $request){
        try {
            $filename="";
            if ($request->hasfile('gambar')) {
                $fileContents = $request->file('gambar');
                $filename = $fileContents->getClientOriginalName();
                $imageFileType = $fileContents->getClientOriginalExtension();

                /* Check file extension */
                $valid_extensions = array("jpg","jpeg","png");
                if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
                    // Logs::writelogs(Auth::user()->id,'Update Banner Failed - wrong image format[use .jpg .jpeg or png image format only]|user='.Auth::user()->id);
                    return response()->json([
                        'success'=>'2',
                        'message'=>"Format gambar tidak mendukung",
                    ]);
                }

                $imagesize = getimagesize($fileContents);
                $imageWidth = $imagesize[0];
                $imageHeight = $imagesize[1];

                $imageDimension = $imageHeight/$imageWidth;
                if ($imageDimension < 0.3 || $imageDimension > 0.4) { //tidak sesuai
                    // Logs::writelogs(Auth::user()->id,'Update Banner Failed - wrong image format[image ratio must 3:1]|user='.Auth::user()->id);
                    return response()->json([
                        'success'=>'3',
                        'message'=>"Ukuran dimensi gambar tidak mendukung",
                    ]);
                }

                // return response()->json([
                //     'success'=>'3',
                //     'size'=>$imagesize,
                //     'message'=>$imageDimension,
                // ]);

                // $request->file('gambar')->move(public_path('Banner'), $filename);

                Storage::disk('s3')->put('omi/Banner/'.$filename, file_get_contents($fileContents));
                $path = Storage::disk('s3')->url('omi/Banner/'.$filename);
                // $path = '';


            } else {
                $path = Banners::searchId(\request('id'))[0]['path_image'];
                // $path = '';
            }

            $id = \request('id');
            $title = \request('title');
            $description = \request('description');
            $path_image = $path;
            $path_thumbnail = $path;

            $masaberlaku = explode(" - ", \request('masaberlaku'));
            $start_date = Carbon::createFromFormat('d/m/Y', $masaberlaku[0])->startOfDay()->addSecond(1);
            $end_date = Carbon::createFromFormat('d/m/Y', $masaberlaku[1])->endOfDay();

            $seq_num = \request('seq_num');
            $is_newtab = \request('isnewtab');
            $onclick_url = \request('tautan');
            $is_clickable = isset($onclick_url) ? '1' : '0';
            $updated_by = null;
            $updated_at = Carbon::now();

            $result = Banners::_update($id, $title, $description, $path_image, $path_thumbnail, $start_date, $end_date, $seq_num, $is_clickable,
            $is_newtab, $onclick_url, $updated_by, $updated_at);

            if ($result == 1) {
                // Logs::writelogs(Auth::user()->id,'Update Banner Success - banner['.$id.'] created|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'1',
                    'message'=>'Banner berhasil diperbaharui',
                ]);
            } else {
                // Logs::writelogs(Auth::user()->id,'Update Banner Failed - System Error|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'2',
                    'message'=>$result,
                ]);
            }

        } catch (Exception $ex) {
            return response()->json([
                'success'=>'0',
                'message'=>$ex->getMessage(),
            ]);
        }

    }

    public function delete(request $request){
        $id = \request('id');
        $deleted_by = null;
        $result = Banners::_delete($id,$deleted_by);
        if ($result == 1) {
            // Logs::writelogs(Auth::user()->id,'Delete Banner Success - banner['.$id.'] deleted|user='.Auth::user()->id);
            return response()->json([
                'success'=>'1',
                'message'=>'Berhasil menghapus banner',
            ]);
        } else {
            // Logs::writelogs(Auth::user()->id,'Delete Banner Failed - System Error|user='.Auth::user()->id);
            return response()->json([
                'success'=>'2',
                'message'=>$result,
            ]);
        }
    }

}
