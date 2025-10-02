<?php

namespace App\Http\Controllers\cmsomi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Roles;
use App\Models\Logs;

class user_controller extends Controller
{
    public function index(request $request){

        try{
            if (Auth::user()->roles != 1) {
                return back()->with('invalid_role_msg', 'Anda tidak memiliki akses');
            }
            $users = User::getUsers_cms(Auth::user()->id, Auth::user()->roles);
            $roles = Roles::getRoles();

            return view('cms-omi/user', [
                'users' => $users,
                'roles' => $roles,
            ]);
        }catch(Exception $ex){
            echo $ex->getMessage();
        }

    }

    public function login_status(request $request){
        try {
            if (Auth::user()->id != null) {
                return 1;
            } else {
                return 0;
            }

        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function login(request $request){
        // return \request('mac');
        $email = \request('email');
        $password = \request('password');
        try {
            $credentials = ['email' => $email, 'password' => $password, 'deleted_at' => '0000-00-00 00:00:00'];
            $isPass = Auth::attempt($credentials);
            if (!$isPass) {
                $credentials = ['email' => $email, 'password' => $password, 'deleted_at' => null];
                $isPass = Auth::attempt($credentials);
            }

            if($isPass){
                // Logs::writelogs(Auth::user()->id,'Login Failed - Invalid Email or Password|user='.null.'email='.$email);
                $user = Auth::user();

                $role_name = Roles::get_RoleTitle($user->roles)[0];

                // dd($role_name);
                session_start();
                $_SESSION["id"] = $user->id;
                $_SESSION["full-name"] = $user->full_name;
                $_SESSION["short-name"] = $user->short_name;
                $_SESSION["email"] = $user->email;
                $_SESSION["role_name"] = $role_name;
                $_SESSION["roles"] = $user->roles;
                $_SESSION["created_at"] = $user->created_at;

                $token = $user->createToken('Token Name')->accessToken;

                // dd($_SESSION);
                // dd($token);
                // $role_name = Roles::get_RoleTitle($user->roles);

                // Logs::writelogs(Auth::user()->id,'Login Success - user['.Auth::user()->id.']|user='.Auth::user()->id);
                return redirect()->route('cms');
            }else {
                return redirect()->route('login')->with('error_msg', 'Username atau Password Salah');
            }


        } catch (Exception $ex) {
            return redirect()->route('login')->with('error_msg', $ex->getMessage());
        }

    }

    public static function register(request $request){
        $full_name = \request('full_name');
        $short_name = \request('short_name');
        $email = \request('email');
        $roles = \request('roles');
        $password = \request('password');
        $re_password = \request('re_password');

        if ($password != $re_password) {
            return response()->json([
                'success'=>'2',
                'message'=>"Password tidak sama",
            ]);
        }

        // Email already available
        $isuseravailable = User::get_email_count($email);
        if (count($isuseravailable) != 0 || $email == null || empty($email)) {
            if ($isuseravailable[0]->deleted_at == '0000-00-00 00:00:00') {

                // Logs::writelogs(Auth::user()->id,'Register Failed - Email Already Registered|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'2',
                    'message'=>"Email sudah terdaftar gunakan email lainnya",
                ]);
            }else {
                $result = User::_restore($isuseravailable[0]->id, $full_name, $short_name, $email, $roles);
                if ($password != null) {
                    $password = bcrypt($password);
                    User::update_password($isuseravailable[0]->id,$password);
                }

                return response()->json([
                    'success'=>'1',
                    'message'=>"User lama dipulihkan",
                ]);
            }
        }
        // /Email already available

        // New Email
        if (\request('password') == null) {
            $password = bcrypt('123456');
        } else {
            $password = bcrypt(\request('password'));
        }

        try {
            $newU = new User;
            $newU->full_name = $full_name;
            $newU->short_name = $short_name;
            $newU->email = $email;
            $newU->password = $password;
            $newU->roles = $roles;
            $newU->created_at = Carbon::now();
            $newU->updated_at = Carbon::now();
            $newU->deleted_at = '0000-00-00 00:00:00';
            $newU->save();

            // Logs::writelogs(Auth::user()->id,'Register Success - user['.$newU->id.'] regitered|user='.Auth::user()->id);
            return response()->json([
                'user'=>$newU,
                'success'=>'1',
                'message'=>"Berhasil menambahkan user",
            ]);

        } catch (Exception $ex) {
            try {
                // Logs::writelogs(Auth::user()->id,'Register Failed - System Error|user='.Auth::user()->id);
            } catch (\Throwable $th) {
                //throw $th;
            }
            return response()->json([
                'success'=>'2',
                'message'=>$ex->getMessage(),
            ]);
        }
        // /New Email

    }

    public function update(request $request){
        // try {
            $id = \request('id');
            $full_name = \request('full_name');
            $short_name = \request('short_name');
            $email = \request('email');
            $roles = \request('roles');
            $password = \request('password');
            $re_password = \request('re_password');


            if ($password != null && ($password != $re_password)) {
                return response()->json([
                    'success'=>'2',
                    'message'=>"Password tidak sama",
                ]);
            }

            $current_email = User::getCurrentEmail($id)[0]->email;

            if ($current_email != $email) {
                if (User::get_email_count($email) != 0 || $email == null || empty($email)) {
                    // Logs::writelogs(Auth::user()->id,'User Update Failed - Email Already Registered|user='.Auth::user()->id);
                    return response()->json([
                        'success'=>'2',
                        'message'=>"Email sudah terdaftar, gunakan email lainnya",
                    ]);
                }
            }


            $result = User::_update($id,$full_name, $short_name, $email, $roles);

            if ($password != null) {
                $password = bcrypt($password);
                User::update_password($id,$password);
            }

            if ($result == 1) {
                // Logs::writelogs(Auth::user()->id,'Register Success - user['.$id.'] regitered|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'1',
                    'message'=>"Berhasil memperbarui user",
                ]);
            } else {
                // Logs::writelogs(Auth::user()->id,'User Update Failed - Cant find user['.$id.']|user='.Auth::user()->id);
                return response()->json([
                    'success'=>'2',
                    'message'=>"Terjadi kesalahan",
                ]);
            }
        // } catch (Exception $ex) {
        //     try {
        //         // Logs::writelogs(Auth::user()->id,'User Update Failed - System Error|user='.Auth::user()->id);
        //     } catch (\Throwable $th) {
        //         //throw $th;
        //     }

        //     return response()->json([
        //         'success'=>'2',
        //         'message'=>$ex->getMessage(),
        //     ]);
        // }
    }

    public function logout(request $request){
        try {
            if (Auth::check()) {
                // Logs::writelogs(Auth::user()->id,'Logout Success - user['.Auth::user()->id.'] logout|user='.Auth::user()->id);
                session_start();
                session_destroy();
                Auth::logout();
                return redirect()->route('login')->with('error_msg', 'Logout berhasil');
             }
        } catch (Exception $ex) {
            try {
                // Logs::writelogs(Auth::user()->id,'Logout Failed - System Error|user='.Auth::user()->id);
            } catch (\Throwable $th) {
                //throw $th;
            }
            return $ex->getMessage();
        }
    }

    public function delete(request $request){
        $id = \request('id');

        if (Auth::user()->id == $id) {
            // Logs::writelogs(Auth::user()->id,'Delete User Failed - Cant delete yourself|user='.Auth::user()->id);
            return response()->json([
                'success'=>'2',
                'message'=>"Tidak dapat menghapus akun sendiri",
            ]);
        }

        $deleted_roles = User::getUserRoles($id);
        if (Auth::user()->roles < $deleted_roles) {
            $result = User::_delete($id);
        }else {
            // Logs::writelogs(Auth::user()->id,'Delete User Failed - Permission denied! cant delete user['.$id.']|user='.Auth::user()->id);
            return response()->json([
                'success'=>'2',
                'message'=>"Anda tidak memiliki izin untuk menghapus user ".$id,
            ]);
        }

        if ($result == 1) {
            // Logs::writelogs(Auth::user()->id,'Delete User Success - user['.$id.']|user='.Auth::user()->id);
            return response()->json([
                'success'=>'1',
                'message'=>"Sukses menghapus user",
            ]);
        } else {
            // Logs::writelogs(Auth::user()->id,'Delete User Failed - System Error|user='.Auth::user()->id);
            return response()->json([
                'success'=>'2',
                'message'=>"Terjadi kesalahan : Gagal menghapus user",
            ]);
        }

    }

    public static function reset_password(request $request){
        $new_password = \request('new_password');
        $confirm_password = \request('confirm_password');

        if (Hash::check(\request('old_password'), Auth::user()->password)) {
            if ($new_password == $confirm_password && $new_password != null) {
                try {
                    $new_password_bcrypt = bcrypt($new_password);
                    $result = User::update_password(Auth::user()->id,$new_password_bcrypt);
                    // Logs::writelogs(Auth::user()->id,'Reset Password Success - user['.Auth::user()->id.']|user='.Auth::user()->id);
                    // return back();
                    return back()->with('success_role_msg', 'Berhasil merubah password');

                } catch (Exception $ex) {
                    // Logs::writelogs(Auth::user()->id,'Reset Password Failed - System Error|user='.Auth::user()->id);
                    return back()->with('invalid_role_msg', 'Gagal merubah password');
                }
            } else {
                // Logs::writelogs(Auth::user()->id,'Reset Password Failed - cant confirm new password|user='.Auth::user()->id);
                return back()->with('invalid_role_msg', 'Periksa kembali password baru anda !');
            }
        }else{
            // Logs::writelogs(Auth::user()->id,'Reset Password Failed - wrong password|user='.Auth::user()->id);
            return back()->with('invalid_role_msg', 'Password lama salah. Periksa kembali password anda !');
        }
    }

}
