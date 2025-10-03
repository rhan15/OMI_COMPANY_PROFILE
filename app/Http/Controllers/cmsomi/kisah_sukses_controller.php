<?php

namespace App\Http\Controllers\cmsomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use PhpParser\Node\Expr\Isset_;
use App\Models\Logs;

use Carbon\Carbon;

use App\Models\Testimonials;

class kisah_sukses_controller extends Controller
{
    public function index(request $request){
        try{
            $testimonials = Testimonials::get_testimoni();
            return view('cms-omi/kisah_sukses', [
                'testimonials' => $testimonials,
            ]);
        }catch(Exception $ex){
            echo $ex->getMessage();
        }
    }
    
    public function add(request $request){
        try {
            $title = \request('title');
            $url = " ";
            $is_video = \request('isvideo');
            $flag_default = \request('flagdefault');
            $description = \request('description');
            $created_by = null;
            
            if ($is_video == 1) {
                $url = \request('tautan');
                if ($url == null) {
                    return response()->json([
                        'success'=>'2',
                        'message'=>"Tautan video belum diisi",
                    ]);
                }
            } else {
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

                    // $imagesize = getimagesize($fileContents);
                    // $imageWidth = $imagesize[0];
                    // $imageHeight = $imagesize[1];

                    // $imageDimension = $imageHeight/$imageWidth;
                    // if ($imageDimension < 1.3 || $imageDimension > 1.4) { //tidak sesuai
                    //     // Logs::writelogs(Auth::user()->id,'Add New Banner Failed - wrong image format[image ratio must 3:1]|user='.Auth::user()->id);

                    //     return response()->json([
                    //         'success'=>'3',
                    //         'message'=>"Ukuran dimensi hanya mendukung 4:3",
                    //     ]);
                    // }

                    // return response()->json([
                    //     'success'=>'3',
                    //     'size'=>$imagesize,
                    //     'message'=>$imageDimension,
                    // ]);

                    // $request->file('gambar')->move(public_path('Banner'), $filename);

                    Storage::disk('s3')->put('Public/comprof/KisahSukses/'.$filename, file_get_contents($fileContents));
                    $path = Storage::disk('s3')->url('Public/comprof/KisahSukses/'.$filename);
                    // $path = '';
                } else {
                    // Logs::writelogs(Auth::user()->id,'Add New Banner Failed - wrong image format[use .jpg .jpeg or png image format only]|user='.Auth::user()->id);
                    return response()->json([
                        'success'=>'2',
                        'message'=>"File gambar tidak terbaca",
                    ]);
                }
                $url = $path;
            }

            $result = Testimonials::_add($title, $url, $is_video, $flag_default,  $description, $created_by);

            if ($result == 1) {
                // Logs::writelogs(Auth::user()->id,'Add New Banner Success - banner'.$title.' created|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'1',
                    'message'=>'Berhasil menambahkan kisah baru',
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
            $id = \request('id');
            $title = \request('title');
            $url = " ";
            $is_video = \request('isvideo');
            $flag_default = \request('flagdefault');
            $description = \request('description');
            $modify_by = null;

            if ($is_video == 1) {
                $url = \request('tautan');
                if ($url == null) {
                    return response()->json([
                        'success'=>'2',
                        'message'=>"Tautan video belum diisi",
                    ]);
                }
            } else {
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

                    // $imagesize = getimagesize($fileContents);
                    // $imageWidth = $imagesize[0];
                    // $imageHeight = $imagesize[1];

                    // $imageDimension = $imageHeight/$imageWidth;
                    // if ($imageDimension < 0.3 || $imageDimension > 0.4) { //tidak sesuai
                    //     // Logs::writelogs(Auth::user()->id,'Update Banner Failed - wrong image format[image ratio must 3:1]|user='.Auth::user()->id);
                    //     return response()->json([
                    //         'success'=>'3',
                    //         'message'=>"Ukuran dimensi gambar tidak mendukung",
                    //     ]);
                    // }

                    // return response()->json([
                    //     'success'=>'3',
                    //     'size'=>$imagesize,
                    //     'message'=>$imageDimension,
                    // ]);

                    // $request->file('gambar')->move(public_path('Banner'), $filename);

                    Storage::disk('s3')->put('Public/comprof/KisahSukses/'.$filename, file_get_contents($fileContents));
                    $path = Storage::disk('s3')->url('Public/comprof/KisahSukses/'.$filename);
                    // $path = '';
                } else {
                    $path = Testimonials::searchId(\request('id'))[0]['url'];
                    // $path = '';
                }
                $url = $path;
            }
            

            $result = Testimonials::_update($id, $title, $url, $is_video, $flag_default,  $description, $modify_by);

            if ($result == 1) {
                // Logs::writelogs(Auth::user()->id,'Add New Banner Success - banner'.$title.' created|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'1',
                    'message'=>'Kisah sukses berhasil diperbaharui',
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

    public function delete(request $request){
        $id = \request('id');
        $deleted_by = "null";
        $result = Testimonials::_delete($id,$deleted_by);
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
