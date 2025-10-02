<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;


class Blogs extends Model
{
    protected $table = 'blogs';

    public static function get_blogs($page){
        $result = Blogs::select('*')
        ->where('deleted_at', null)
        ->orderBy('created_at', 'desc')
        ->paginate(9, ['*'], 'page', $page);

        $new_result = [];
        foreach ($result as $rsl) {
            $tag = Tag_blogs::get_tags($rsl['id']);
            $rsl['tags'] =$tag;
            $new_result [] = $rsl;
        }

        $val ['blogs'] = $new_result;
        $val ['last_page'] = $result->lastPage();
        return $val;
    }

    public static function get_detail($id){
        $result = Blogs::select('*')
        ->where('id',$id)->first();
        return $result;
    }

    public static function get_otherblog($blog_id){
        $tag = Tag_blogs::select('tag_id')->where('blog_id',$blog_id)->pluck('tag_id');
        $blog_id = Tag_blogs::select('blog_id')
            ->whereIn('tag_id', $tag)
            ->where('blog_id','!=',$blog_id)
            ->where('deleted_at', '0000-00-00 00:00:00')
            ->pluck('blog_id');

        $theBlogs = Blogs::select('*')
                    ->whereIn('id',$blog_id)
                    ->orderBy('created_at', 'desc')
                    ->get();
        return $theBlogs;
    }

    // public static function get_banners_cms(){
    public static function searchId($id){
        $result = Blogs::select('*')
                ->where('id', $id)
                ->get();
        return $result;
    }

    public static function search($key){
        $result = Blogs::select('*')
        ->where('title','like', '%'.$key.'%')
        ->get();
        return $result;
    }

    public static function getBlog_cms(){
        $result = Blogs::leftjoin('tag_blogs', 'blogs.id', '=','tag_blogs.blog_id')
                ->select('blogs.*', Blogs::raw('group_concat(tag_blogs.tag_id) as tags'))
                ->where('blogs.deleted_at', null)
                ->orderBy('blogs.created_at', 'desc')
                ->groupBy('id')
                ->get();
        return $result;
    }

    public static function _add($title, $description, $path_image, $path_thumbnail, $created_by){
        try {
            $result = Blogs::insertGetId(
                ['title' => $title,
                'description' => $description,
                'path_image' => $path_image,
                'path_thumbnail' => $path_thumbnail,
                'created_by' => Auth::user()->id,
                // 'updated_by' => $created_by,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
                ]
            );
            return $result;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function _update($id, $title, $description, $path_image, $path_thumbnail, $updated_by){
        try {
            $result = Blogs::where('id',$id)
            ->update(
                ['title' => $title,
                'description' => $description,
                'path_image' => $path_image,
                'path_thumbnail' => $path_thumbnail,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now()
                ]
            );
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }

    }

    public static function _delete($id,$deleted_by){
        try {
            $result = Blogs::where('id',$id)
            ->update(
                [
                 'deleted_by' => Auth::user()->id,
                 'deleted_at' => Carbon::now(),
                ]
            );
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
