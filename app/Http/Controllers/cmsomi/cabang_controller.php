<?php

namespace App\Http\Controllers\cmsomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Storage;

use App\Models\Branch;
use App\Models\Province;
use PhpParser\Node\Expr\Isset_;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;

class cabang_controller extends Controller
{
    public function index(request $request){
        try{
            $branches = Branch::get_branches_cms();
            $provinces = Province::get_all_province();
            return view('cms-omi/cabang',[
                'branches' => $branches,
                'provinces' => $provinces,
            ]);
        }catch(Exception $ex){
            echo $ex->getMessage();
        }
    }

    public function add(request $request){
        try {

            $branch_name = \request('branch_name');
            $province_id = \request('province_id');

            $result = Branch::_add($province_id, $branch_name);

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
            $branch_name = \request('branch_name');
            $province_id = \request('province_id');

            $result = Branch::_update($id, $province_id, $branch_name);

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
            $result = Branch::_delete($id);

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
