<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;


class Sejarah extends Model
{
    protected $table = 'histories';

    public static function get_history(){
        $result = Sejarah::select('*')
        ->get();
        return $result;
    }
}
