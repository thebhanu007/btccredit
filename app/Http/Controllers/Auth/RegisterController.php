<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Session;
use Illuminate\Support\Str;
use DB;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'referrer_id' => 'required|string|size:12',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|numeric',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \blog\User
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

        public function register(Request $request)
        {
            $this->validator($request->all())->validate();

            event(new Registered($user = $this->create($request->all())));

            //$this->guard()->login($user);
            Session::flash('alert', 'alert-success');
            Session::flash('message', 'Verification email sent to your email id.');
            return $this->registered($request, $user)
                            ?: redirect($this->redirectPath());
        }

        public function get_unique_id()
        {
            $timestamp = rand(10000000,99999999);
                $check =   DB::table('users')
                                 ->select('userid')
                                 ->where('userid',  "BTCC".$timestamp)
                                 ->first();
            if(!empty($check)){	
                    return $this->get_unique_id();
            }
            else{
                    return $timestamp;				
            }
            
        }
    
    protected function create(array $data)
    {
        $data['userid'] = "BTCC".$this->get_unique_id();
        $data["verify_token"] = Str::random(32);
        Mail::send('mail', $data, function($message) use($data){
            $message->to($data['email'], 'BTCC')->subject
               ('BTCC Verify Mail');
            $message->from('btcc@gmail.com','BTCC');
         });
        return User::create([
            'userid' => $data['userid'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone_number' => $data['phone_number'],
            'country_code' => $data['phone_number_phoneCode'],
            'email' => $data['email'],
            'referrer_id' => $data["referrer_id"],
            'password' => bcrypt($data['password']),
            'verify_token' => $data["verify_token"],
        ]);
    }
}
