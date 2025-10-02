<?php

namespace App\Http\Controllers\webomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\captcha;
use App\Models\Contact_persons;
use App\Models\Company_info;
use App\Models\Feedbacks;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Feedback_recipents;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;

use Exception;


class hubungikamiController extends Controller
{
    public function index()
    {
        $contact = Contact_persons::get_contact();
        $company = Company_info::get_company();
        return view('web-omi/hubungi_kami', [
            'Contact' => $contact,
            'Company' => $company,
        ]);
    }

    public function get_address()
    {
        try{
            $company = Company_info::get_company();
            return response()->json([
                'company'=>$company,
            ]);
        }catch(Exception $ex){
            return response()->json([
                'company'=>[],
            ]);
        }
    }

    public function saran() {
        try{
            $gRecaptchaResponse = \request('recaptcha');
            $user_name = \request('user_name');
            $email= \request('email');
            $phone= \request('phone');
            $province= \request('province');
            $content= \request('content');
            $created_at = Carbon::now();

            $captcha = captcha::validation($gRecaptchaResponse);

            if ($captcha==1) {
                $result = Feedbacks::addFeedbacks($user_name,$email,$phone,$province,$content,$created_at);

                $id_feedback = $result;

                if (!is_numeric($result) ) {
                    return response()->json([
                        'AlertIcon'=> 'success',
                        'AlertInfo' => 'Saran Telah Terkirim',
                    ]);
                };

                //Get recipents
                $recipents = Feedback_recipents::get();
                $emails = [];
                foreach ($recipents as $recipent) {
                    array_push($emails, $recipent['email']);
                }

                $body = "<table>
                            <tr>
                                <td>Email</td>
                                <td>: $email </td>
                            </tr>

                            <tr>
                                <td>Nama</td>
                                <td>: $user_name </td>
                            </tr>

                            <tr>
                                <td>No Hp</td>
                                <td>: $phone </td>
                            </tr>

                            <tr>
                                <td>Kota / Provinsi</td>
                                <td>: $province </td>
                            </tr>

                            <tr>
                                <td>Pesan</td>
                                <td>:</td>
                            </tr>
                        </table>".
                        "<br>". strip_tags($content);

                \Mail::send([], [], function($message) use ($emails, $body)
                {
                    $mailFrom = env('MAIL_FROM_ADDRESS');
                    $message->to($emails)
                            ->from($mailFrom, 'omifranchise.co.id')
                            ->subject('Feedback OMI')
                            ->setBody($body, 'text/html');
                });

                if (\Mail::failures()) {
                    // fail to sending
                    // is_sent still 0

                    return response()->json([
                        'message' => \Mail::failures(),
                        'AlertIcon'=> 'success',
                        'AlertInfo' => 'Saran Telah Terkirim',
                    ]);
                };

                // Update is_sent 1
                // ..............
                Feedbacks::updateSend($id_feedback);
                // ./Update is_sent 1

                return response()->json([
                    'AlertIcon'=> 'success',
                    'AlertInfo' => 'Saran Telah Terkirim',
                ]);
            } else {
                return response()->json([
                    'AlertIcon'=> "error",
                    'AlertInfo' => "Anda Terdeteksi Sebagai Robot",
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success'=>'0',
                'AlertInfo'=>$th->getMessage(),
                'AlertIcon'=> "error",
            ]);
        }
    }
}
