<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqGroup extends Model
{
    protected $table = 'faq_group';

    public static function get_FaqGruop(){
        $result = FaqGroup::select('*')
        ->get();
        return $result;
    }

}