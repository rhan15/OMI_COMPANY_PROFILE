<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;

class Feedback_recipents extends Model
{
    protected $table = 'recipents';

    public static function getCms(){
        $Feedback_recipents = Feedback_recipents::select('*')
            ->where('deleted_at', null)
            ->get();
        return $Feedback_recipents;
    }

    public static function get(){
        $Feedback_recipents = Feedback_recipents::select('*')
            ->where('deleted_at', null)
            ->get();
        return $Feedback_recipents;
    }

    public static function _add($email, $flagfedback, $flagregister){
        try {
            $result = Feedback_recipents::insertGetId([
                'email' => $email,
                'flag_feedback' => $flagfedback,
                'flag_register' => $flagregister,
                'created_at' => Carbon::now()
            ]);
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function _update($id, $email, $flagfedback, $flagregister){
        try {
            $result = Feedback_recipents::where('id', $id)
            ->update([
                'email' => $email,
                'flag_feedback' => $flagfedback,
                'flag_register' => $flagregister,
                'updated_at' => Carbon::now()
            ]);
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function _delete($id){
        try {
            $result = Feedback_recipents::where('id',$id)
            ->update([
                 'deleted_at' => Carbon::now()
            ]);
            return 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
