<?php

namespace App\Http\Controllers\cmsomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use App\Models\Blogs;
use App\Models\Tags;
use App\Models\Tag_blogs;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;

class blog_controller extends Controller
{
    public function index(request $request){
        try{

            $key = \request('key');

            if ($request->has('key')) {
                $blogs = Blogs::search($key);
            }else{
                $blogs = Blogs::getBlog_cms();
            }
            $tags = Tags::get();

            return view('cms-omi/berita', [
                'blogs' => $blogs,
                'tags' => $tags,
            ]);
        }catch(Exception $ex){
            echo $ex->getMessage();
        }
    }

    public function add(request $request){
        try{
            $filename="";
            if ($request->hasfile('gambar')) {
                $fileContents = $request->file('gambar');
                $filename = $fileContents->getClientOriginalName();
                $imageFileType = $fileContents->getClientOriginalExtension();

                /* Check file extension */
                $valid_extensions = array("jpg","jpeg","png");
                if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
                    // Logs::writelogs(Auth::user()->id,'Add New Blog Failed - wrong image format[use .jpg .jpeg or png image format only]|user='.Auth::user()->id);
                    return response()->json([
                        'success'=>'2',
                        'message'=>"Format gambar tidak mendukung",
                    ]);
                }

                /* Check image dimension */
                // $imagesize = getimagesize($fileContents);
                // $imageWidth = $imagesize[0];
                // $imageHeight = $imagesize[1];

                // $imageDimension = $imageHeight/$imageWidth;
                // if ($imageDimension < 0.5 || $imageDimension > 0.6) { //tidak sesuai
                //     Logs::writelogs(Auth::user()->id,'Add New Blog Failed - wrong image format[image ratio must 2:1]|user='.Auth::user()->id);
                //     return response()->json([
                //         'success'=>'3',
                //         'message'=>"Ukuran dimensi hanya mendukung 1:2",
                //     ]);
                // }
                /* ./Check image dimension */

                // $request->file('gambar')->move(public_path('Blog'), $filename);
                // AWS
                Storage::disk('s3')->put('igr/Blog/'.$filename, file_get_contents($fileContents));
                $path = Storage::disk('s3')->url('igr/Blog/'.$filename);

            } else {
                $path = null;
            }

            $title = \request('title');
            $tag = explode(",", \request('tags')); //string to array
            $tags = Tags::check_tag($tag); // cek tag, jika belum terdaftar maka akan di masukkan kedalam database
            $description = \request('description');
            $path_image = $path;
            $path_thumbnail = $path;
            $created_by =\request('created_by');

            //insert berita
            $result = Blogs::_add($title, $description, $path_image, $path_thumbnail, $created_by);

            //insert tag berita
            $id_blog = $result;

            foreach ($tags as $tag) {
                Tag_blogs::_add($id_blog, $tag);
            }

            // Logs::writelogs(Auth::user()->id,'Add New Blog Success - blog['.$id_blog.'] created|user='.Auth::user()->id);
            return response()->json([
                'success'=>'1',
                'messege'=>'Berita berhasil ditambahkan',
            ]);
        }catch(Exception $ex){
            try {
                // Logs::writelogs(Auth::user()->id,'Add New Blog Failed - System Error|user='.Auth::user()->id);
            } catch (\Throwable $th) {
                //throw $th;
            }
            return response()->json([
                'success'=>'0',
                'messege'=>$ex->getMessage(),
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
                    // Logs::writelogs(Auth::user()->id,'Update Blog Failed - wrong image format[use .jpg .jpeg or png image format only]|user='.Auth::user()->id);
                    return response()->json([
                        'success'=>'2',
                        'message'=>"Format gambar tidak mendukung",
                    ]);
                }
                /* ./Check file extension */


                /* Check image dimension */
                // $imagesize = getimagesize($fileContents);
                // $imageWidth = $imagesize[0];
                // $imageHeight = $imagesize[1];

                // $imageDimension = $imageHeight/$imageWidth;
                // if ($imageDimension < 0.5 || $imageDimension > 0.6) { //tidak sesuai
                //     Logs::writelogs(Auth::user()->id,'Update Blog Failed - wrong image format[image ratio must 2:1]|user='.Auth::user()->id);
                //     return response()->json([
                //         'imageDimension'=>$imagesize,
                //         'success'=>'3',
                //         'message'=>"Ukuran dimensi hanya mendukung 2:1",
                //     ]);
                // }
                /* ./Check image dimension */


                // $request->file('gambar')->move(public_path('Blog'), $filename);
                // AWS
                Storage::disk('s3')->put('igr/Blog/'.$filename, file_get_contents($fileContents));
                $path = Storage::disk('s3')->url('igr/Blog/'.$filename);
            } else {
                $path = Blogs::searchId(\request('id'))[0]['path_image'];
            }

            $id = \request('id');
            $title = \request('title');
            $tag = explode(",", \request('tags')); //string to array
            $tags = Tags::check_tag($tag); // cek tag, jika belum terdaftar maka akan di masukkan kedalam database
            $description = \request('description');
            $updated_by =\request('updated_by');

            $result = Blogs::_update($id, $title, $description, $path, $path, $updated_by);

            //insert tag berita
            $id_blog = $id;
            Tag_blogs::_delete($id_blog);

            if ($result == 1) {


                foreach ($tags as $tag) {
                    Tag_blogs::_add($id_blog, $tag);
                }

                // Logs::writelogs(Auth::user()->id,'Update Blog Success - blog['.$id.'] updated|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'1',
                    'message'=>$result,
                ]);
            } else {
                // Logs::writelogs(Auth::user()->id,'Update Blog Failed - System Error|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'2',
                    'message'=>$result,
                ]);
            }

        } catch (Exception $ex) {
            try {
                // Logs::writelogs(Auth::user()->id,'Update Blog Failed - System Error|user='.Auth::user()->id);
            } catch (\Throwable $th) {
                //throw $th;
            }
            return response()->json([
                'success'=>'0',
                'message'=>$ex->getMessage(),
                'messsage'=>\request('id'),
            ]);
        }

    }

    public function delete(request $request){
        $id = \request('id');
        $deleted_by = \request('deleted_by');
        $result = Blogs::_delete($id, $deleted_by);
        if ($result == 1) {
            // Logs::writelogs(Auth::user()->id,'Delete Blog Success - blog['.$id.'] deleted|user='.Auth::user()->id);
            return response()->json([
                'success'=>'1',
                'message'=>'Berhasil menghapus berita',
            ]);
        } else {
            // Logs::writelogs(Auth::user()->id,'Delete Blog Failed - System Error|user='.Auth::user()->id);
            return response()->json([
                'success'=>'2',
                'message'=>$result,
            ]);
        }
    }

}
