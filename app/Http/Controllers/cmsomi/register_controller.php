<?php

namespace App\Http\Controllers\cmsomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;

use App\Models\Register;

class register_controller extends Controller
{
    public function index(request $request){
        try{
            $Register = Register::get_registers_cms();
            // dd($Register);

            return view('cms-omi/pendaftaran', [
                'registers' => $Register,
            ]);
        }catch(Exception $ex){
            echo $ex->getMessage();
        }
    }

    public function export_excel(request $request){
        return '';
    }
}
