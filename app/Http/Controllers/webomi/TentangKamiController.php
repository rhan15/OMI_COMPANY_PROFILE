<?php

namespace App\Http\Controllers\webomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Exception;

use App\Models\Sejarah;

class TentangKamiController extends Controller
{
    public function index()
    {
        $History = Sejarah::get_history();
        return view('web-omi/tentang_kami', [
            'History' => $History,
        ]);
    }
}
