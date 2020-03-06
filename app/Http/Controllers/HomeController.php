<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateTransactionPasswordRequest;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['userdetail'] = DB::table('users')
        ->select(DB::raw('count(*) as referrals'))
        ->where('referrer_id', Auth::user()->userid)
        ->first();
        return view('home', $data);
    }
    public function profile()
    {
        $data['countries'] = DB::table('country')
        ->select('*')
        ->get();
        return view('profile', $data);
    }
    public function update_profile(UpdateProfileRequest $request)
    {
        DB::table('users')
        ->where('id', Auth::user()->id)
        ->update(['first_name' => $request->first_name, 'last_name' => $request->last_name, 'email' => $request->email, 'country_code' => $request->country_code, 'phone_number' => $request->phone_number, 'btc_address' => $request->btc_address]);     
        Session::flash('alert', 'alert-success');
        Session::flash('message', 'Profile Updated successfully.');
        return redirect()->back();
        exit;
    }
    public function update_passwords(UpdatePasswordRequest $request)
    {
        DB::table('users')
        ->where('id', Auth::user()->id)
        ->update(['password' => bcrypt($request->password), 'updated_at' => date('Y-m-d h:i:s')]);     
        Session::flash('alert', 'alert-success');
        Session::flash('message', 'Password Updated successfully.');
        return redirect()->back();
        exit;
    }
    public function update_transaction_password(UpdateTransactionPasswordRequest $request)
    {
        DB::table('users')
        ->where('id', Auth::user()->id)
        ->update(['transaction_password' => md5($request->transaction_password), 'updated_at' => date('Y-m-d h:i:s')]);     
        Session::flash('alert', 'alert-success');
        Session::flash('message', 'Transaction Password Updated successfully.');
        return redirect()->back();
        exit;
    }

    
    public function buy_package()
    {
        $data["last_unpaid_transaction"] = DB::table('main_wallet_deposit_history')
        ->where('status', '1')
        ->where('user_id', '=', Auth::user()->id)
        ->first();

        return view('buy-package', $data);
    }
    public function transfer_to_holding_wallet()
    {
        return view('transfer-to-holding-wallet');
    }
    public function transfer_amount_to_hw(Request $request)
    {
        if(Auth::user()->main_wallet_balance < $request->amount){
            Session::flash('alert', 'alert-danger');
            Session::flash('message', 'Your main account balance is not enough.');
            return redirect()->back();
            exit;
        }
        if($request->amount < 150){
            Session::flash('alert', 'alert-danger');
            Session::flash('message', 'Minimum Transfer amount is $150.');
            return redirect()->back();
            exit;
        }
        DB::table('holding_wallet_history')->insert(
            ['amount_in_usd' => $request->amount, 'package_type' => $request->package_type, 'user_id'=> Auth::user()->id]
        );
        DB::table('users')->where('id', Auth::user()->id)->decrement('main_wallet_balance', $request->amount);
        if($request->package_type == 'Fix'){
            DB::table('users')->where('id', Auth::user()->id)->increment('fix_holding_wallet_balance', $request->amount);
        }
        elseif($request->package_type == 'Growth'){
            DB::table('users')->where('id', Auth::user()->id)->increment('growth_holding_wallet_balance', $request->amount);
        }
        Session::flash('alert', 'alert-success');
        Session::flash('message', 'Amount transfered successfully.');
        return redirect()->back();
        exit;
    }
    public function transfer_to_token_holding_wallet()
    {
        return view('transfer-to-token-holding-wallet');
    }
    public function transfer_amount_to_thw(Request $request)
    {
        if(Auth::user()->token_wallet_balance < $request->amount){
            Session::flash('alert', 'alert-danger');
            Session::flash('message', 'Your token wallet balance is not enough.');
            return redirect()->back();
            exit;
        }
        DB::table('token_holding_wallet_history')->insert(
            ['tokens' => $request->amount, 'user_id'=> Auth::user()->id]
        );
        DB::table('users')->where('id', Auth::user()->id)->decrement('token_wallet_balance', $request->amount);
        DB::table('users')->where('id', Auth::user()->id)->increment('token_holding_wallet_balance', $request->amount);
        Session::flash('alert', 'alert-success');
        Session::flash('message', 'Amount transfered successfully.');
        return redirect()->back();
        exit;
    }

    public function fix_plan_details(Request $request)
    {
        $data['package_detail'] = DB::table('holding_wallet_history')
        ->leftJoin('withdraw_fix_holding', 'withdraw_fix_holding.holding_id', '=', 'holding_wallet_history.id')
        ->select(DB::raw('holding_wallet_history.*, withdraw_fix_holding.created_at as withdraw_date, withdraw_fix_holding.deduction_percentage as deduction_percentage'))
        ->where('holding_wallet_history.user_id', Auth::user()->id)
        ->where('holding_wallet_history.package_type', 'Fix')
        ->get();
        return view('fix-plan', $data);
    }
    public function growth_plans(Request $request)
    {
        $data['packages_detail'] = DB::table('holding_wallet_history')
        ->select('*')
        ->where('user_id', Auth::user()->id)
        ->where('package_type', 'Growth')
        ->get();
        return view('growth-plans', $data);
    }
    public function direct_referrals(Request $request)
    {
        $data['direct_referrals'] = DB::table('users')
        ->select('*')
        ->where('referrer_id', Auth::user()->userid)
        ->get();
        return view('direct-referrals-list', $data);
    }
    public function all_referrals(Request $request)
    {
        $direct_referrals[1] = DB::table('users')
        ->where('referrer_id', Auth::user()->userid)
        ->pluck('userid')
        ->all();
        $data['direct_referrals_records'][1] = DB::table('users')
        ->where('referrer_id', Auth::user()->userid)
        ->select('*')
        ->get();

        for($i=2; $i<=21; $i++){
            $direct_referrals[$i] = DB::table('users')
            ->whereIn('referrer_id', $direct_referrals[$i-1])
            ->pluck('userid')
            ->all();
            if(empty($direct_referrals[$i])){
                break;
            }
            $data['direct_referrals_records'][$i] = DB::table('users')
                ->whereIn('referrer_id', $direct_referrals[$i-1])
                ->select('*')
                ->get();
        }
        return view('all-referrals-list', $data);
    }

    
    public function downline_referrals(Request $request)
    {
        $data['downline_referrals'] = DB::table('users')
        ->select('*')
        ->where('referrer_id', Auth::user()->userid)
        ->get();
        return view('downline-referrals-list', $data);
    }
    
	public function generate_ticket()
	{
		return view('generate-ticket');		
	}
    public function get_unique_id()
    {
        $timestamp = rand(10000000,99999999);
            $check =   DB::table('support_queries')
                             ->select('ticket_id')
                             ->where('ticket_id',  "BTCC".$timestamp)
                             ->first();
        if(!empty($check)){	
                return $this->get_unique_id();
        }
        else{
                return $timestamp;				
        }
        
    }
     
	public function transfer_tokens()
	{
		return view('transfer-tokens');		
    }
          
	public function transfer_tokens_to_other_user(Request $request)
	{
        $check_userid = DB::table('users')
        ->where('userid', '=',  $request->userid)
        ->where('userid', '!=',  Auth::user()->userid)
        ->first();

        if(!$check_userid){
            Session::flash('alert', 'alert-danger');
            Session::flash('message', 'User Id Not Found.');
            return redirect()->back();
            exit;
        }
        if(Auth::user()->token_wallet_balance < $request->tokens){
            Session::flash('alert', 'alert-danger');
            Session::flash('message', 'Your token wallet balance is not enough.');
            return redirect()->back();
            exit;
        }
        $insert = DB::table('tokens_transfer_history')->insert(
			['transfer_to' => $check_userid->id, 'transfer_from' => Auth::user()->id, 'tokens' => $request->tokens]
        );
        DB::table('users')->where('id', Auth::user()->id)->decrement('token_wallet_balance', $request->tokens);
        DB::table('users')->where('id', $check_userid->id)->increment('token_wallet_balance', $request->tokens);

		if($insert){
			Session::flash('message', "Tokens Transfered Successfully.");
			Session::flash('alert', "alert-success");
            return redirect()->back();
		}
		else{
			Session::flash('message', "Somthing went wrong! Please try again!");
			Session::flash('alert', "alert-danger");
            return redirect()->back();
		}
	}

	public function withdraw_main_wallet()
	{
		return view('withdraw-main-wallet');		
    }
	public function withdraw_main_wallet_to_btc(Request $request)
	{
        if(Auth::user()->main_wallet_balance < $request->amount){
            Session::flash('alert', 'alert-danger');
            Session::flash('message', 'Your main wallet balance is not enough.');
            return redirect()->back();
            exit;
        }
        $insert = DB::table('withdraw_main_wallet_requests')->insert(
			['usd' => $request->amount, 'user_id' => Auth::user()->id, 'btc_address' => Auth::user()->btc_address]
        );
        DB::table('users')->where('id', Auth::user()->id)->decrement('main_wallet_balance', $request->amount);

		if($insert){
			Session::flash('message', "Withdraw Request Sent Successfully.");
			Session::flash('alert', "alert-success");
            return redirect()->back();
		}
		else{
			Session::flash('message', "Somthing went wrong! Please try again!");
			Session::flash('alert', "alert-danger");
            return redirect()->back();
		}
	}
    
	public function withdraw_tokens()
	{
        $data['token_rate'] = DB::table('token_rate')
        ->select('*')
        ->first();
		return view('withdraw-tokens', $data);		
	}
	public function withdraw_tokens_to_main_wallet(Request $request)
	{
        if(Auth::user()->token_wallet_balance < $request->tokens){
            Session::flash('alert', 'alert-danger');
            Session::flash('message', 'Your token wallet balance is not enough.');
            return redirect()->back();
            exit;
        }
        $token_rate = DB::table('token_rate')
        ->select('*')
        ->first();
        $usd = $token_rate->token_price * $request->tokens;
        $insert = DB::table('withdraw_token_holding')->insert(
			['tokens' => $request->tokens, 'user_id' => Auth::user()->id, 'usd_converted' => $usd, 'token_rate' =>  $token_rate->token_price]
        );
        DB::table('users')->where('id', Auth::user()->id)->decrement('token_wallet_balance', $request->tokens);
        DB::table('users')->where('id', Auth::user()->id)->increment('main_wallet_balance', $usd);

		if($insert){
			Session::flash('message', "Withdraw Successfull.");
			Session::flash('alert', "alert-success");
            return redirect()->back();
		}
		else{
			Session::flash('message', "Somthing went wrong! Please try again!");
			Session::flash('alert', "alert-danger");
            return redirect()->back();
		}
	}
        
	public function add_query(Request $request)
	{
        $ticket_id = "BTCC".$this->get_unique_id();
		$insert = DB::table('support_queries')->insert(
			['ticket_id' => $ticket_id, 'subject' => $request->subject, 'content' => $request->content, 'status' =>  'Pending', 'user_id' => Auth::user()->id]
		);
		if($insert){
			Session::flash('message', "We Have Received Your Query! Our Support Team Will Contact You Soon.");
			Session::flash('alert', "alert-success");
			return redirect('/view-tickets');	
		}
		else{
			Session::flash('message', "Somthing went wrong! Please try again!");
			Session::flash('alert', "alert-danger");
            return redirect()->back();
		}
	}
	public function view_tickets()
	{
		 $data["alltickets"] = DB::table('support_queries')
								 ->select('*')
								 ->where('user_id',  Auth::user()->id)
								 ->get();
					return view('view-tickets', $data);		
	}
	public function send_withdrawal_request(Request $request)
	{
        $withdraw_detail = DB::table('holding_wallet_history')
        ->select('*')
        ->where('user_id',  Auth::user()->id)
        ->where('id',  $request->holding_id)
        ->where('package_type',  'Fix')
        ->where('withdraw_status',  0)
        ->first();

        if(empty($withdraw_detail)){
			Session::flash('message', "Please select a fix plan!");
			Session::flash('alert', "alert-danger");
            return redirect()->back();
        }
        $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', date('Y-m-d H:i:s', strtotime($withdraw_detail->created_at)));
        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', date('Y-m-d H:i:s'));
        $months = $to->diffInMonths($from);
        $amount = $withdraw_detail->amount_in_usd;
        $deduction_percentage = 1;
        if($months == 0){
          $deduction_percentage = 25;
        }
        else if($months == 1){
          $deduction_percentage = 15;
        }
        else if($months == 2){
          $deduction_percentage = 5;
        }
        $deduction_amount = $amount * $deduction_percentage / 100;
        $withdrawable_amount = $amount - $deduction_amount;
    
        $insert = DB::table('withdraw_fix_holding')->insert(
			['transferable_amount' => $withdrawable_amount, 'user_id' => Auth::user()->id, 'deducted_amount' => $deduction_amount, 'deduction_percentage' =>  $deduction_percentage, 'base_amount' => $amount, 'holding_id' => $withdraw_detail->id]
        );
        DB::table('holding_wallet_history')
        ->where('id', $request->holding_id)
        ->update(['withdraw_status' => 1]);   

        DB::table('users')->where('id', Auth::user()->id)->decrement('fix_holding_wallet_balance', $amount);

		if($insert){
			Session::flash('message', "We Have Received Your Withdrawal Request! Your Request Will Be Approved Soon.");
			Session::flash('alert', "alert-success");
            return redirect()->back();
		}
		else{
			Session::flash('message', "Somthing went wrong! Please try again!");
			Session::flash('alert', "alert-danger");
            return redirect()->back();
		}
	}

    

// add by tarachand

public function token_earning_report()
{
    $data['token_earning_report'] = DB::table('token_wallet_history')
    ->select('*')
    ->where('user_id', Auth::user()->id)
    ->orderBy('created_at')
    ->get();
    return view('token-earning-report', $data);
}

public function main_wallet_transaction()
{
    $data['main_wallet_transaction'] = DB::select(
        DB::raw('SELECT * FROM 
        (SELECT "Deposit" as transaction_type, a.amount, a.status, a.coins, a.created_at  FROM main_wallet_deposit_history as a WHERE user_id = '.Auth::user()->id.' and status != 0 
        UNION ALL SELECT "Token Withdrawal" as transaction_type, c.usd_converted, "2" as status, "0" as bitcoins, c.created_at FROM withdraw_token_holding as c WHERE user_id = '.Auth::user()->id.'
        UNION ALL SELECT "Withdraw" as transaction_type, b.usd, b.status, b.bitcoins, b.created_at FROM withdraw_main_wallet_requests as b WHERE user_id = '.Auth::user()->id.') 
        AS A ORDER BY created_at'));

    return view('main-wallet-transaction', $data);
}

public function holding_wallet_transaction()
{
    $data['holding_wallet_transaction'] = DB::table('holding_wallet_history')
    ->select('*')
    ->where('user_id', Auth::user()->id)
    ->orderBy('created_at')
    //->where('status', 1)
    ->get();
    return view('holding-wallet-transaction', $data);
}
public function token_holding_report()
{
    $data['token_holding_report'] = DB::table('token_holding_wallet_history')
    ->select('*')
    ->where('user_id', Auth::user()->id)
    ->orderBy('created_at')
    //->where('status', 1)
    ->get();
    return view('token-holding-report', $data);
}
public function referral_income_report()
{
    $data['referral_income_reports'] = DB::table('referral_commission_history')
    ->select('*')
    ->where('commission_of', Auth::user()->id)
    ->orderBy('created_at')
    //->where('status', 1)
    ->get();
    return view('referral-income-report', $data);
}


    
    
    
}
