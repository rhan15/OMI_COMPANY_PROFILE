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
use App\Models\Feedback_recipents;



class feedback_recipents_controller extends Controller
{
    public function index(request $request){
        try{
            $recipents = Feedback_recipents::getCms();
            return view('cms-omi/feedback_recipents',[
                'recipents' => $recipents,
            ]);
        }catch(Exception $ex){
            echo $ex->getMessage();
        }
    }

    public function add(request $request){
        try {
            $email = \request('email');
            $flags = explode(",", \request('flags'));
            $flagfedback=0;
            $flagregister=0;

            foreach ($flags as $flag) {
                if ($flag == 1) {
                    $flagfedback = 1;
                }else if($flag == 2){
                    $flagregister = 1;
                }
            }

            $result = Feedback_recipents::_add($email, $flagfedback, $flagregister);

            if ($result == 1) {
                // Logs::writelogs(Auth::user()->id,'Add New Recipient Success - Recipient['.$email.'] created|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'1',
                    'message'=>'Berhasil menambahkan email baru',
                ]);
            } else {
                // Logs::writelogs(Auth::user()->id,'Add New Recipient Failed- Email Already Registered|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'0',
                    'message'=>$result,
                ]);
            }

        } catch (Exception $ex) {
            try {
                // Logs::writelogs(Auth::user()->id,'Add New Recipient Failed- System Error|user='.Auth::user()->id);
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
            $id = \request('id');
            $email = \request('email');

            $flags = explode(",", \request('flags'));
            $flagfedback=0;
            $flagregister=0;

            foreach ($flags as $flag) {
                if ($flag == 1) {
                    $flagfedback = 1;
                }else if($flag == 2){
                    $flagregister = 1;
                }
            }

            $result = Feedback_recipents::_update($id, $email, $flagfedback, $flagregister);

            if ($result == 1) {
                // Logs::writelogs(Auth::user()->id,'Update Recipient Success - Recipient['.$email.'] created|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'1',
                    'message'=>'Berhasil memperbarui email',
                ]);
            } else {
                // Logs::writelogs(Auth::user()->id,'Update Recipient Failed- Email Already Registered|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'0',
                    'message'=>$result,
                ]);
            }

        } catch (Exception $ex) {
            try {
                // Logs::writelogs(Auth::user()->id,'Update Recipient Failed- System Error|user='.Auth::user()->id);
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
        try {
            $id = \request('id');
            $result = Feedback_recipents::_delete($id);

            if ($result == 1) {
                Logs::writelogs(Auth::user()->id,'Delete Recipient Success - Recipient['.$id.'] deleted|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'1',
                    'message'=>'Berhasil menghapus email',
                ]);
            } else {
                Logs::writelogs(Auth::user()->id,'Delete Reciepent Failed- System Error|user='.Auth::user()->id);
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

}
