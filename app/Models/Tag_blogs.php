<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;

class Tag_blogs extends Model
{
    protected $table = 'tag_blogs';

    public static function get_tags($blog_id){
        $tag = Tag_blogs::select('tags.title')
            ->leftJoin('tags', 'tag_blogs.tag_id', '=', 'tags.id')
            ->where('tag_blogs.blog_id', '=', $blog_id)
            ->get();
        $combine_tags = [];
            foreach ($tag as $title) {
                $combine_tags [] = $title->title;
            }
        return $combine_tags;
    }

    public static function _add($blog_id, $tag_id){
        try{
            Tag_blogs::insert(
                [
                    'tag_id' => $tag_id,
                    'blog_id' => $blog_id,
                    'created_at' => Carbon::now(),
                ]
            );
            return 1;
        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }

    public static function _delete($blog_id){
        try{
            Tag_blogs::where('blog_id', $blog_id)
            ->delete();
            return 1;
        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }


}
