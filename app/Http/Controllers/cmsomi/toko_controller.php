<?php

namespace App\Http\Controllers\cmsomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Storage;

use App\Models\Shops;
use App\Models\Branch;
use PhpParser\Node\Expr\Isset_;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;

class toko_controller extends Controller
{
    public function index(request $request){
        try{
            $branches = Branch::get_branches_cms();
            $shops = Shops::get_shops_cms();
            return view('cms-omi/toko',[
                'branches' => $branches,
                'shops' => $shops,
            ]);
        }catch(Exception $ex){
            echo $ex->getMessage();
        }
    }

    public function add(request $request){
        try {

            $branch_id = \request('branch_id');
            $shop_name = \request('shop_name');
            $address = \request('address');
            $longitude = \request('longitude');
            $latitude = \request('latitude');

            $result = Shops::_add($branch_id, $shop_name, $address, $longitude, $latitude);

            if ($result == 1) {
                // Logs::writelogs(Auth::user()->id,'Add New Branch Success - branch '.$short_name.' created|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'1',
                    'message'=>'Berhasil menambahkan cabang baru',
                ]);
            } else {
                // Logs::writelogs(Auth::user()->id,'Add New Branch Failed - System Error|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'0',
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
            // cek kode cabang
            $id = \request('id');
            $branch_id = \request('branch_id');
            $shop_name = \request('shop_name');
            $address = \request('address');
            $longitude = \request('longitude');
            $latitude = \request('latitude');


            $result = Shops::_update($id, $branch_id, $shop_name, $address, $longitude, $latitude);

            if ($result == 1) {
                // Logs::writelogs(Auth::user()->id,'Update Branch Success - branch['.$id.'] updated|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'1',
                    'message'=>'Berhasil memperbarui cabang',
                ]);
            } else {
                // Logs::writelogs(Auth::user()->id,'Update Branch Failed - System Error|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'0',
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
        try {
            $id = \request('id');
            $result = Shops::_delete($id);

            if ($result == 1) {
                // Logs::writelogs(Auth::user()->id,'Delete Branch Success - branch['.$id.'] deleted|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'1',
                    'message'=>'Berhasil menghapus cabang',
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
