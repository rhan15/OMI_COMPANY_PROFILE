<?php

namespace App\Models;
use Carbon\Carbon;
use Exception;

use Illuminate\Database\Eloquent\Model;

class Ownership extends Model
{
    protected $table = 'location_ownerships';

    public static function get(){
        $result = Ownership::select('*')
            ->orderBy('created_at', 'desc')
            ->get();
        return $result;
    }
}
