<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $table = 'tags';

    public static function get(){
        $tags = Tags::select('*')
            ->get();
        return $tags;
    }

    public static function check_tag($array_of_tags){
        foreach ($array_of_tags as $tag) {
            if (is_numeric($tag)) {
                $the_id [] = $tag;
            }else{
                $result = Tags::insertGetId([
                    'title' => $tag,
                ]);
                $the_id [] = $result;
            }
        }
        return $the_id;
    }
}
