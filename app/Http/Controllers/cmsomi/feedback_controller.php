<?php

namespace App\Http\Controllers\cmsomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;

use App\Models\Feedbacks;
use App\Models\Feedback_recipents;

class feedback_controller extends Controller
{
    public function index(request $request){
        try{
            $Feedbacks = Feedbacks::get();
            return view('cms-omi/feedback', [
                'feedbacks' => $Feedbacks,
            ]);
        }catch(Exception $ex){
            echo $ex->getMessage();
        }
    }

    public function send(request $request){
        try{
            //geting data
            $id_feedback = \request('id');
            $email = \request('email');
            $phone = \request('phone');
            $user_name = \request('user_name');
            $province= \request('province');
            $content = \request('content');

            // Get recipents
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

                // Logs::writelogs(Auth::user()->id,'Send Feedback Failed- cant send feedback['.$id_feedback.'] to ['.$email.']|user=');
                return response()->json([
                    'success'=>'2',
                    'message'=>\Mail::failures(),
                ]);
            };

            // Update is_sent 1
            // ..............
            Feedbacks::updateSend($id_feedback);
            // ./Update is_sent 1

            // Logs::writelogs(Auth::user()->id,'Send Feedback Success - feedback['.$id_feedback.'] sent|user='.Auth::user()->id);
            return response()->json([
                'success'=>'1',
                'message'=>"Feedback terkirim",
            ]);

        }catch(Exception $ex){
            try {
                // Logs::writelogs(Auth::user()->id,'Send Feedback Failed- System Error|user='.Auth::user()->id);
            } catch (\Throwable $th) {
                //throw $th;
            }
            return response()->json([
                'success'=>'2',
                'message'=>$ex->getMessage(),
            ]);
            // echo $ex->getMessage();
        }
    }

}
