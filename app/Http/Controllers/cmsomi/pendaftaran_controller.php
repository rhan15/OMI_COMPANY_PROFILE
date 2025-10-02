<?php

namespace App\Http\Controllers\cmsomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use PhpParser\Node\Expr\Isset_;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\RegisterExport;
use App\Models\Register;

class pendaftaran_controller extends Controller
{
    public function index(request $request){
        try{

            $date_range = \request('range');
            if (isset($date_range)) {
                // dd($date_range);
                $date = explode(" - ", $date_range);
                $start_date = Carbon::createFromFormat('d/m/Y', $date[0])->startOfDay()->addSecond(1);
                $end_date = Carbon::createFromFormat('d/m/Y', $date[1])->endOfDay();
                $registers = Register::get_preview_registers_cms($start_date, $end_date);

                return view('cms-omi/pendaftaran', [
                    'registers' => $registers,
                    'print' => true,
                    'date_range' => $date_range,
                ]);
            }

            $registers = Register::get_registers_cms();
            return view('cms-omi/pendaftaran', [
                'registers' => $registers,
                'print' => false,
            ]);
        }catch(Exception $ex){
            echo $ex->getMessage();
        }
    }

    public function export_excel(request $request){
        try{
            $param_range = \request('range');
            if (isset($param_range)) {
                $range = explode(" - ", $param_range);
                $start_date = Carbon::createFromFormat('d/m/Y', $range[0])->startOfDay()->addSecond(1);
                $end_date = Carbon::createFromFormat('d/m/Y', $range[1])->endOfDay();
    
                return Excel::download(new RegisterExport($start_date, $end_date), 'registers.xlsx');
            } else {
                return Excel::download(new RegisterExport(null, null), 'registers.xlsx');
            }
        }catch(Exception $ex){
            echo $ex->getMessage();
        }
    }

}
