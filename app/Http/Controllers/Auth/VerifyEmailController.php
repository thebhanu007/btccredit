<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Session;
use Auth;
use Illuminate\Contracts\Auth\Authenticable;
class VerifyEmailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function verify_email($userid, $verify_token)
    {
        $user = DB::table('users')
        ->select('*')
        ->where('verify_token', $verify_token)
        ->where('userid', $userid)
        ->first();

        if($user){
            $verify = DB::table('users')
            ->where('id', $user->id)
            ->update(['email_verified' => 1]);
            Auth::loginUsingId($user->id);
            return redirect('/home');
        }
        else{
            Session::flash('message', 'Verification link expired.');
            return redirect('/register');
        }
    }
}
