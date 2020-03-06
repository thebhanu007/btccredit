<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Myliabrary\CoinPaymentsAPI;
use Mail;
class AjaxController extends HomeController
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
       
    public function check_old_password(Request $request){
        //if ($_SERVER['HTTP_USER_AGENT'] != 'checkcron') exit;
        if (Auth::attempt(array('email' => Auth::user()->email, 'password' =>  $request->old_password))){
            return "true";
        }
        else {        
                return "false";
        }
     }
     public function check_transaction_password(Request $request){
        //if ($_SERVER['HTTP_USER_AGENT'] != 'checkcron') exit;
        $transaction = DB::table('users')
        ->where('transaction_password', md5($request->transaction_password))
        ->where('id', Auth::user()->id)
        ->first();
        if ($transaction){
            return "true";
        }
        else {        
                return "false";
        }
     }
     public function check_payment_status(){
		//if ($_SERVER['HTTP_USER_AGENT'] != 'checkcron') exit;
		 $transaction = DB::table('main_wallet_deposit_history')
                ->where('status', '1')
                ->where('user_id', Auth::user()->id)
                ->first();
		if($transaction){
				$cps = new CoinPaymentsAPI();
      // $cps->Setup('Ae50bdeb136a01877Cbc97097F9827290DAb998353AA910FA69076816C7A2391', '06603c4401674b88a2f235d6e0098e42cdfdce6e42718df89037208006c8da73');
            $cps->Setup('9bBbaa301294dAFC8eC06511d712b50119e52908fBd78d5e44d4D6B451fdc458', '2f79796688e0124749d695cbac23911ed50dc3767bb315633d712ad7e2aefdee');
            // See https://www.coinpayments.net/apidoc-create-transaction for all of the available fields
            $result = $cps->get_tx_info($transaction->transaction_id);
            if ($result['error'] == 'ok') {
                if(isset($result['result']['status'])){
                    if($result['result']['status'] === 100){
                        DB::table('users')->where('id',$transaction->user_id)->increment('main_wallet_balance', $transaction->amount);
                        DB::table('main_wallet_deposit_history')->where('id',$transaction->id)->update(['status'=> '2', 'approved_at' => date('Y-m-d H:i:s')]);
                        echo json_encode(['status' => "success"]);
                    }
                    elseif($result['result']['status'] === -1){
                        DB::table('main_wallet_deposit_history')->where('id',$transaction->id)->update(['status'=> '0', 'approved_at' => date('Y-m-d H:i:s')]);
                        echo json_encode(['status' => "canceled"]);
                    }
                    else{
                        echo json_encode(['status' => "pending"]);
                    }		
                }	
            }
		}
     }
     
    public function get_referrals(Request $request)
    {
        $users = DB::table('users')
        ->select('first_name', 'id', 'userid')
        ->where('referrer_id', $request->id)
        ->get();
        echo json_encode($users);
    }
    public function generate_qrcode(Request $request)
    {
        $last_unpaid_transaction = DB::table('main_wallet_deposit_history')
        ->where('status', '1')
        ->where('user_id', '=', Auth::user()->id)
        ->first();
        if($last_unpaid_transaction){
            echo json_encode(["error"=> "ok", "result"=>["qrcode_url" => $last_unpaid_transaction->qrcode_url, "amount" => $last_unpaid_transaction->coins, "address" => $last_unpaid_transaction->address]]);
            exit;
        }
       $cps = new CoinPaymentsAPI();
      // $cps->Setup('Ae50bdeb136a01877Cbc97097F9827290DAb998353AA910FA69076816C7A2391', '06603c4401674b88a2f235d6e0098e42cdfdce6e42718df89037208006c8da73');
      $cps->Setup('9bBbaa301294dAFC8eC06511d712b50119e52908fBd78d5e44d4D6B451fdc458', '2f79796688e0124749d695cbac23911ed50dc3767bb315633d712ad7e2aefdee');
      $address = '';
        $userdetail = DB::table('users')
                        ->where('id', '=',  Auth::user()->id)
                        ->first();
              
       $req = array(
           'amount' => $request->amount,
           'currency1' => 'USD',
           'currency2' => 'BTC',
           'address' =>  $address, // leave blank send to follow your settings on the Coin Settings page
           'buyer_email' => 'rajenderksuthar@gmail.com',
       );
       // See https://www.coinpayments.net/apidoc-create-transaction for all of the available fields
               
       $result = $cps->CreateTransaction($req);  
       if ($result['error'] == 'ok') {
           $insert = DB::table('main_wallet_deposit_history')->insert([
               ['amount' => $request->amount,'transaction_id'=>$result['result']['txn_id'],'address'=>$result['result']['address'], 'user_id' => Auth::user()->id, 'status' =>  '1', 'confirms_needed'=>$result['result']['confirms_needed'], 'status_url' =>$result['result']['status_url'], 'qrcode_url' =>$result['result']['qrcode_url'], 'coins' => sprintf('%.08f', $result['result']['amount'])]
           ]);
           //$le = php_sapi_name() == 'cli' ? "\n" : '<br />';
           //print 'Transaction created with ID: '.$result['result']['txn_id'].$le;
           //print 'Buyer should send'.sprintf('%.08f', $result['result']['amount']).' BTC'.$le;
           //print 'Status URL: '.$result['result']['status_url'].$le;
           echo json_encode($result);
           
       } else {
           print json_encode($result['error']);
       }
   }
   public function send_otp(Request $request)
   {
       $data['otp'] = $request->otp;
        Mail::send('send-otp', $data, function($message) use($data){
            $message->to(Auth::user()->email, 'BTCC')->subject
            ('BTCC OTP.');
            $message->from('btcc@gmail.com','BTCC');
        });
        echo "success";

   }
   public function send_withdraw_otp(Request $request)
   {
       $data['otp'] = $request->otp;
        Mail::send('send-withdrawal-otp', $data, function($message) use($data){
            $message->to(Auth::user()->email, 'BTCC')->subject
            ('BTCC OTP.');
            $message->from('btcc@gmail.com','BTCC');
        });
        echo "success";

   }
   public function send_transfer_otp(Request $request)
   {
       $data['otp'] = $request->otp;
        Mail::send('send-transfer-otp', $data, function($message) use($data){
            $message->to(Auth::user()->email, 'BTCC')->subject
            ('BTCC OTP.');
            $message->from('btcc@gmail.com','BTCC');
        });
        echo "success";

   }
   public function get_user_details(Request $request)
   {
        $userdetail = DB::table('users')
        ->where('userid', '=',  $request->id)
        ->where('userid', '!=',  Auth::user()->userid)
        ->first();
        echo json_encode($userdetail);
   }
   
}
