<?php

namespace App\Http\Controllers\webomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FaqGroup;
use App\Models\Faqs;
use App\Models\Testimonials;

use Exception;

class waralabaController extends Controller
{
    public function index()
    {
        $FaqGroup = FaqGroup::get_FaqGruop();
        $Faq = Faqs::get_Faqs();
        $Testimonials = Testimonials::get_testimoni();
        $menu = array("Mengapa OMI", "Syarat & Ketentuan", "Jenis Investasi", "Kisah Sukses","Tanya Jawab", "Persebaran OMI");
        return view('web-omi/waralaba', [
            'Menu' => $menu,
            'FaqCategory' => $FaqGroup,
            'Faq' => $Faq,
            'Testimonials' => $Testimonials,
        ]);
    }
}
