<?php

namespace App\Http\Controllers\cmsomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Storage;

use PhpParser\Node\Expr\Isset_;
use App\Models\Logs;
use App\Models\Contact_persons;
use Illuminate\Support\Facades\Auth;

class kontak_controller extends Controller
{
    public function index(request $request){
        try{
            $contact = Contact_persons::get_contact();
            return view('cms-omi/kontak_wilayah', [
                'contact' => $contact,
            ]);
        }catch(Exception $ex){
            echo $ex->getMessage();
        }
    }

    public function add(request $request){
        try {
            $area = \request('area');
            $name = \request('name');
            $address = \request('address');
            $handphone = \request('handphone');
            $whatsapp = \request('whatsapp');
            $phone = \request('phone');
            $email = \request('email');

            $result = Contact_persons::_add($area, $name, $address, $handphone, $whatsapp, $phone, $email);
            if (is_numeric($result)) {
                // Logs::writelogs(Auth::user()->id,'Register Success - user['.$id.'] regitered|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'1',
                    'message'=>"Berhasil memperbarui kontak",
                ]);
            } else {
                // Logs::writelogs(Auth::user()->id,'User Update Failed - Cant find user['.$id.']|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'2',
                    'message'=>$result,
                ]);
            }
        } catch (Exception $ex) {
            try {
                // Logs::writelogs(Auth::user()->id,'User Update Failed - System Error|user='.Auth::user()->id);
            } catch (\Throwable $th) {
                //throw $th;
            }

            return response()->json([
                'success'=>'2',
                'message'=>$ex->getMessage(),
            ]);
        }
    }

    public function update(request $request){
        try {
            $id = \request('id');
            $area = \request('area');
            $name = \request('name');
            $address = \request('address');
            $handphone = \request('handphone');
            $whatsapp = \request('whatsapp');
            $phone = \request('phone');
            $email = \request('email');

            $result = Contact_persons::_update($id, $area, $name, $address, $handphone, $whatsapp, $phone, $email);
            if ($result == 1) {
                // Logs::writelogs(Auth::user()->id,'Register Success - user['.$id.'] regitered|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'1',
                    'message'=>"Berhasil memperbarui kontak",
                ]);
            } else {
                // Logs::writelogs(Auth::user()->id,'User Update Failed - Cant find user['.$id.']|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'2',
                    'message'=>$result,
                ]);
            }
        } catch (Exception $ex) {
            try {
                // Logs::writelogs(Auth::user()->id,'User Update Failed - System Error|user='.Auth::user()->id);
            } catch (\Throwable $th) {
                //throw $th;
            }

            return response()->json([
                'success'=>'2',
                'message'=>$ex->getMessage(),
            ]);
        }
    }

    public function delete(request $request){
        try {
            $id = \request('id');
            $result = Contact_persons::_delete($id);

            if ($result == 1) {
                // Logs::writelogs(Auth::user()->id,'Delete Branch Success - branch['.$id.'] deleted|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'1',
                    'message'=>'Berhasil menghapus kontak',
                ]);
            } else {
                // Logs::writelogs(Auth::user()->id,'Update Branch Failed - System Error|user='.Auth::user()->id);
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
