<?php

namespace App\Http\Controllers\cmsomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Roles;
use Exception;

class dashboard_controller extends Controller
{
    public function index(request $request){
        try{
            return view('cms-omi/dashboard');
        }catch(Exception $ex){
            echo $ex->getMessage();
        }
    }

}
