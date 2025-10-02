<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;
use ReCaptcha\ReCaptcha;

class captcha extends Model 
{
    public static function validation($gRecaptchaResponse){
            $secret = '6LdPg_QZAAAAAGl_q4JAHLcT7yG36Kf19Vcf8izj';
            
            $recaptcha = new ReCaptcha($secret);
            $resp = $recaptcha->verify($gRecaptchaResponse, $_SERVER['REMOTE_ADDR']);

            return $resp->isSuccess();
    }
}