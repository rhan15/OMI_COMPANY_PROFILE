<?php

namespace App\Models;
use Carbon\Carbon;
use Exception;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'educations';

    public static function get(){
        $result = Education::select('*')
            ->orderBy('created_at', 'desc')
            ->get();
        return $result;
    }
}
