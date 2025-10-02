<?php

namespace App\Models;
use Carbon\Carbon;
use Exception;

use Illuminate\Database\Eloquent\Model;

class Feedbacks extends Model
{
    protected $table = 'feedbacks';

    public static function get(){
        $Feedbacks = Feedbacks::select('*')
            ->orderBy('created_at', 'desc')
            ->get();
        return $Feedbacks;
    }

    public static function updateSend($id){
        $Feedbacks = Feedbacks::where('id', $id)
            ->update([
                'is_sent' => '1',
                // 'updated_by' => $updated_by,
                'updated_at' => Carbon::now()
            ]);
        return 1;
    }

    public static function addFeedbacks($user_name, $email, $phone,$province, $content, $created_at){
        try {
            $result = Feedbacks::insertGetId(
                [
                    'user_name' => strip_tags($user_name),
                    'email' => strip_tags($email),
                    'phone' => strip_tags($phone),
                    'province' => strip_tags($province),
                    'content' => strip_tags($content),
                    'created_at' => $created_at,
                ]
            );
            return $result;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
