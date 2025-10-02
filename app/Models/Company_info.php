<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company_info extends Model
{
    protected $table = 'company_info';

    public static function get_company(){
        $result = Company_info::select('*')
        ->get();
        return $result;
    }

}