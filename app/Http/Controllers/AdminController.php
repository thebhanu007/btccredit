<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Session::forget(['admin_id', 'admin_type']);
        return redirect('admin/login');
    }

    public function index()
    {
        return view('admin/index');
    }
    
    public function login(Request $request)
    {
        $admindetail = DB::table('admin')
        ->select('*')
        ->where('user_name', $request->email)
        ->where('password', md5($request->password))
        ->first();
        if(!empty($admindetail)){
            Session::put('admin_id', $admindetail->id);
            Session::put('admin_type', $admindetail->type);
            Session::flash('msg', 'Login Success');
            Session::flash('color', 'alert-success');
            return redirect('admin/dashboard');
        }else{
            Session::flash('msg', 'Enter Correct Email and Password');
            Session::flash('color', 'alert-danger');
            return redirect('admin/login');
        }
    }

    public function dashboard()
    {
        $data['user'] = DB::table('users')
        ->select(DB::raw('count(id) as total_users'))
        ->first();
        $data['deposite'] = DB::table('main_wallet_deposit_history')
        ->select(DB::raw('sum(amount) as total_deposite'))
        ->where('status', 2)
        ->first();
        return view('admin/dashboard', $data);
    }

    public function user_list()
    {
        $data['users'] = DB::table('users')
        ->leftJoin('users as a', 'a.referrer_id', '=', 'users.userid')
        ->select('users.*', DB::raw('count(a.id) as total_refer'))
        ->groupBy('a.referrer_id')
        ->get();
        return view('admin/users-list', $data);
    }

    public function token_price()
    {
        return view('admin/token-price');
    }

    public function token_price_update(Request $request)
    {
        $update_price = DB::table('token_rate')
        ->update(array('token_price' => $request->amount));
       // $update_price = token_rate::where('token_price', $request->amount)->first();
        if(!empty($update_price)){
            Session::flash('msg', 'Update Success');
            Session::flash('color', 'alert-success');
        }else{
            Session::flash('msg', 'Something Went Wrong');
            Session::flash('color', 'alert-danger');
        }
        return redirect('admin/token-price');
    }

    public function main_wallet_withdrawal_requests()
    {
        $data['requests'] = DB::table('withdraw_main_wallet_requests as a')
        ->leftJoin('users as b', 'b.id', '=', 'a.user_id')
        ->select(DB::raw('a.*, b.first_name, b.last_name, b.userid, b.email'))
        ->get();
        return view('admin/main-wallet-withdrawal-requests', $data);
    }

       
}
