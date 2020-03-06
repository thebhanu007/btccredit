<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use Carbon\Carbon;
use App\Myliabrary\CoinPaymentsAPI;

class CronController extends Controller
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
    public function verify_deposit(){
		//if ($_SERVER['HTTP_USER_AGENT'] != 'checkcron') exit;
        $token_rate = DB::table('token_rate')
        ->select('token_price')
        ->first();
		 $last_unapproved_transactions = DB::table('main_wallet_deposit_history')
                ->where('status', '1')
                ->where('created_at', '>', Carbon::now()->subDays(1))
                ->get();
		if($last_unapproved_transactions){
			foreach($last_unapproved_transactions as $transaction){
				$cps = new CoinPaymentsAPI();
      // $cps->Setup('Ae50bdeb136a01877Cbc97097F9827290DAb998353AA910FA69076816C7A2391', '06603c4401674b88a2f235d6e0098e42cdfdce6e42718df89037208006c8da73');
      $cps->Setup('9bBbaa301294dAFC8eC06511d712b50119e52908fBd78d5e44d4D6B451fdc458', '2f79796688e0124749d695cbac23911ed50dc3767bb315633d712ad7e2aefdee');
                
                // See https://www.coinpayments.net/apidoc-create-transaction for all of the available fields
                $result = $cps->get_tx_info($transaction->transaction_id);
				if ($result['error'] == 'ok') {
                    if(isset($result['result']['status'])){
                        if($result['result']['status'] === 100){
                            $get_user_details = DB::table('users')
                            ->where('id', $transaction->user_id)
                            ->first();
                            DB::table('users')->where('id',$transaction->user_id)
                            ->update([
                                'main_wallet_balance'=> DB::raw('main_wallet_balance + '.$transaction->amount), 
                                'self_deposit'=> DB::raw('self_deposit + '.$transaction->amount), 
                                'self_active' => '1'
                                ]);
                            DB::table('users')->where('userid' ,$get_user_details->referrer_id)->increment('direct_active_joinings', 1);
                            DB::table('main_wallet_deposit_history')->where('id',$transaction->id)->update(['status'=> '2', 'approved_at' => date('Y-m-d H:i:s')]);
                            //calculate level income
                            for($j=1; $j <= 11; $j++){
                                $commission_percentage = [7, 5, 3, 2, 1, .5, .5, .5, .5, .5, .5];
                                $get_user_details = DB::table('users')
                                ->where('userid', $get_user_details->referrer_id)
                                ->first();
                                if(empty($get_user_details)){
                                    break;
                                }
                                if($get_user_details->direct_active_joinings < $j){
                                    continue;
                                }
                                if($j == 5){
                                    $self_holding =  $get_user_details->fix_holding_wallet_balance + $get_user_details->growth_holding_wallet_balance;
                                    if($self_holding < 501)
                                        continue;
                                }
                                if($j == 11){
                                    $self_holding =  $get_user_details->fix_holding_wallet_balance + $get_user_details->growth_holding_wallet_balance;
                                    if($self_holding < 1501)
                                        continue;
                                }
                                
                                $commission_of = $get_user_details->id;
                                $commission_by = $transaction->user_id;
                                $income_of_level = $j;
                                $total_commission_in_usd = $transaction->amount * $commission_percentage[$j-1] / 100;
                                $total_commission_in_tokens = $total_commission_in_usd / $token_rate->token_price;
                                DB::table('referral_commission_history')
                                ->insert(['commission_of'=> $commission_of, 'commission_by'=> $commission_by, 'tokens'=> $total_commission_in_tokens, 'usd'=> $total_commission_in_usd, 'token_rate'=> $token_rate->token_price, 'level'=> $income_of_level, 'commission_for'=> 'Instant' ]);
                                DB::table('users')->where('id',$commission_of)->update([
                                    'earning_wallet_balance'=> DB::raw('earning_wallet_balance +'.$total_commission_in_tokens),
                                    'token_wallet_balance'=> DB::raw('token_wallet_balance +'.$total_commission_in_tokens),
                                ]);
                            }                
                        }
                        elseif($result['result']['status'] === -1){
                            DB::table('main_wallet_deposit_history')->where('id',$transaction->id)->update(['status'=> '0', 'approved_at' => date('Y-m-d H:i:s')]);
                        }		
                    }	
				}
			}
		}
     }
     public function get_percentage($usd, $percentage_of){
        $roi_percentage_from_fix_holdings = 0;
        $roi_percentage_from_growth_holdings = 0;
        $roi_percentage_from_token_holdings = 0;
        if($usd >= 150 && $usd <= 500){
            $roi_percentage_from_fix_holdings = 5;
            $roi_percentage_from_growth_holdings = 12;
            $roi_percentage_from_token_holdings = 7.5;
        }
        elseif($usd > 500 && $usd <= 1500){
            $roi_percentage_from_fix_holdings = 5.5;
            $roi_percentage_from_growth_holdings = 13;
            $roi_percentage_from_token_holdings = 8.25;
        }
        elseif($usd > 1500 && $usd <= 3000){
            $roi_percentage_from_fix_holdings = 6;
            $roi_percentage_from_growth_holdings = 14;
            $roi_percentage_from_token_holdings = 9;
        }
        elseif($usd > 3000 && $usd <= 7500){
            $roi_percentage_from_fix_holdings = 6.5;
            $roi_percentage_from_growth_holdings = 15;
            $roi_percentage_from_token_holdings = 9.75;
        }
        elseif($usd > 7500 && $usd <= 15000){
            $roi_percentage_from_fix_holdings = 7;
            $roi_percentage_from_growth_holdings = 16;
            $roi_percentage_from_token_holdings = 10.5;
        }
        elseif($usd > 15000 && $usd <= 25000){
            $roi_percentage_from_fix_holdings = 7.5;
            $roi_percentage_from_growth_holdings = 17;
            $roi_percentage_from_token_holdings = 11.25;
        }
        elseif($usd > 25000){
            $roi_percentage_from_fix_holdings = 8;
            $roi_percentage_from_growth_holdings = 18;
            $roi_percentage_from_token_holdings = 12;
        }
        if($percentage_of == 'Fix'){
            return $roi_percentage_from_fix_holdings;
        }
        elseif($percentage_of == 'Growth'){
            return $roi_percentage_from_growth_holdings;
        }
        elseif($percentage_of == 'Token'){
            return $roi_percentage_from_token_holdings;
        }
     }
     public function calculate_level_income($userid, $amount, $token_rate, $type){
        $get_user_details = DB::table('users')
        ->where('id', $userid)
        ->first();

        //calculate level income
        for($j=1; $j <= 21; $j++){
            $commission_percentage = [20, 10, 5, 4, 3, 2, 1, 1, 1, 1, 3, .5, .5, .5, .5, .5, .5, .5, .5, .5, 3];
            $get_user_details = DB::table('users')
            ->where('userid', $get_user_details->referrer_id)
            ->first();
            if(empty($get_user_details)){
                break;
            }
            if($get_user_details->direct_active_joinings < $j){
                continue;
            }
            if($j == 5){
                $self_holding =  $get_user_details->fix_holding_wallet_balance + $get_user_details->growth_holding_wallet_balance;
                if($self_holding < 501)
                    continue;
            }
            if($j == 11){
                $self_holding =  $get_user_details->fix_holding_wallet_balance + $get_user_details->growth_holding_wallet_balance;
                if($self_holding < 1501)
                    continue;
            }
            $group = [15, 16, 17, 18, 19, 20];
            if(in_array($j, $group)){
                $self_holding =  $get_user_details->fix_holding_wallet_balance + $get_user_details->growth_holding_wallet_balance;
                if($self_holding < 3001)
                    continue;
            }
            $commission_of = $get_user_details->id;
            $commission_by = $userid;
            $income_of_level = $j;
            $total_commission_in_usd = ($amount * $commission_percentage[$j-1] / 100) / 30;
            $total_commission_in_tokens = $total_commission_in_usd / $token_rate;
            DB::table('referral_commission_history')
            ->insert(['commission_of'=> $commission_of, 'commission_by'=> $commission_by, 'tokens'=> $total_commission_in_tokens, 'usd'=> $total_commission_in_usd, 'token_rate'=> $token_rate, 'level'=> $income_of_level, 'commission_for'=> $type ]);
            DB::table('users')->where('id',$commission_of)->update([
                'earning_wallet_balance'=> DB::raw('earning_wallet_balance +'.$total_commission_in_tokens),
                'token_wallet_balance'=> DB::raw('token_wallet_balance +'.$total_commission_in_tokens),
            ]);
        }
     }
     public function generate_tokens(){
        //if ($_SERVER['HTTP_USER_AGENT'] != 'checkcron') exit;
        $token_rate = DB::table('token_rate')
        ->select('token_price')
        ->first();
        //generate token from fix holdings
        $all_fix_holdings = DB::table('holding_wallet_history')
                ->select(DB::raw('*, SUM(amount_in_usd) as amount'))
                ->where('package_type', 'Fix')
                ->where('created_at', '<', Carbon::now()->subDays(1))
                ->groupBy('user_id')
                ->get();

            if($all_fix_holdings){
                foreach($all_fix_holdings as $holding){
                    $roi_percentage = $this->get_percentage($holding->amount, 'Fix');
                    $roi_amount =  ($holding->amount * $roi_percentage / 100)/30;
                    $tokens = $roi_amount / $token_rate->token_price;
                    DB::table('token_wallet_history')->insert(
                        ['tokens' => $tokens, 'income_from' => 'fix_holding', 'user_id'=> $holding->user_id, 'usd_converted' => $roi_amount, 'token_rate' => $token_rate->token_price, 'holding_id' =>$holding->id, 'roi_percentage' => $roi_percentage]
                    );
                    DB::table('holding_wallet_history')->where('id', $holding->id)->increment('roi_generated', $roi_amount);
                    DB::table('users')->where('id', $holding->user_id)->increment('token_wallet_balance', $tokens);
                            $this->calculate_level_income($holding->user_id, $holding->amount, $token_rate->token_price, 'Fix Holding');
                }
            }
         //generate token from growth holdings           
         $all_growth_holdings = DB::table('holding_wallet_history')
         ->select('*')
         ->where('package_type', 'Growth')
         ->where('roi_stop', '<>', '1')
         ->where('created_at', '<', Carbon::now()->subDays(1))
         ->get();
         if($all_growth_holdings){
             foreach($all_growth_holdings as $holding){
                $roi_percentage = $this->get_percentage($holding->amount_in_usd, 'Growth');
                $last_roi = 0;
                 $roi_amount =  ($holding->amount_in_usd * $roi_percentage / 100)/30;
                 $max_roi = $holding->amount_in_usd * 2;

                 if($max_roi < ($holding->roi_generated + $roi_amount)){
                     $roi_amount = $max_roi - $holding->roi_generated;
                     $last_roi = 1;
                     DB::table('holding_wallet_history')
                     ->where('id', $holding->id)
                     ->update(['roi_stop' => 1]);    
                 }
                 $tokens = $roi_amount / $token_rate->token_price;

                 DB::table('token_wallet_history')->insert(
                     ['tokens' => $tokens, 'last_roi' => $last_roi, 'income_from' => 'growth_holding', 'user_id'=> $holding->user_id, 'usd_converted' => $roi_amount, 'token_rate' => $token_rate->token_price, 'holding_id' =>$holding->id, 'roi_percentage' => $roi_percentage]
                 );
                 DB::table('holding_wallet_history')->where('id', $holding->id)->increment('roi_generated', $roi_amount);
                 DB::table('users')->where('id', $holding->user_id)->increment('token_wallet_balance', $tokens);
                 $this->calculate_level_income($holding->user_id, $holding->amount_in_usd, $token_rate->token_price, 'Growth Holding');
                }
         }
         //generate token from token holdings           
         $all_token_holdings = DB::table('token_holding_wallet_history')
         ->select(DB::raw('*, SUM(tokens) as tokens'))
         ->where('created_at', '<', Carbon::now()->subDays(1))
         ->groupBy('user_id')
         ->get();
         if($all_token_holdings){
             foreach($all_token_holdings as $holding){
                 $token_value_in_usd = $holding->tokens * $token_rate->token_price;
                 $roi_percentage = $this->get_percentage($token_value_in_usd, 'Token');
                 $tokens =  ($holding->tokens * $roi_percentage / 100)/30;
                 $usd_converted = $tokens  * $token_rate->token_price;
                 DB::table('token_wallet_history')->insert(
                     ['tokens' => $tokens, 'income_from' => 'token_holding', 'user_id'=> $holding->user_id, 'usd_converted' => $usd_converted, 'token_rate' => $token_rate->token_price, 'holding_id' =>$holding->id, 'roi_percentage' => $roi_percentage]
                 );
                 DB::table('users')->where('id', $holding->user_id)->increment('token_wallet_balance', $tokens);
             }
         }
}
    
    
    
}
