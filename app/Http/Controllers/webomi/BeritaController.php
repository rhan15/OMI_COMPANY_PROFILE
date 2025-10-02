<?php

namespace App\Http\Controllers\webomi;

use App\Models\Blogs;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BeritaController extends Controller
{
    public function index()
    {
        $page = \request('page');
        if ($page == null) {
            $page = 1;
        }
        $blogs = Blogs::get_blogs($page);

        return view('web-omi/berita', [
            'blogs' => $blogs['blogs'],
            'page' => $page,
            'last_page' => $blogs['last_page']
        ]);
    }

    public static function get_detailberita(request $request){
        $id = \request('id');
        $blog = Blogs::get_detail($id);
        $other = Blogs::get_otherblog($id);
        if ($other->isEmpty()) {
            $blogs = Blogs::get_blogs(1);
            $other = $blogs['blogs'];
        }

        return view('web-omi/detail_berita', [
            'blog' => $blog,
            'other' => $other,
        ]);
    }
}
