<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;

class Faqs extends Model
{
    protected $table = 'faqs';

    public static function get_Faqs(){
        $result = Faqs::select('faqs.*','faq_group.title AS faq_category')
        ->leftjoin('faq_group','faqs.faq_group_id','=','faq_group.id')
        ->get();
        return $result;
    }
}
