<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/* user admin route */

Route::get('/admin/logout', 'AdminController@logout');
Route::get('/admin/login', 'AdminController@index');
Route::post('/admin/login', 'AdminController@login');
Route::get('/admin/dashboard', 'AdminController@dashboard');
Route::get('/admin/user-list', 'AdminController@user_list');
Route::get('/admin/token-price', 'AdminController@token_price');
Route::post('/admin/token-price-update', 'AdminController@token_price_update');
Route::get('/admin/main-wallet-withdrawal-requests', 'AdminController@main_wallet_withdrawal_requests');
Route::get('/admin/approve-main-wallet-withdrawal-requests/{id}', 'AdminController@approve_main_wallet_withdrawal_requests');
Route::delete('/admin/decline-main-wallet-withdrawal-requests/{id}', 'AdminController@decline_main_wallet_withdrawal_requests');

// user admin route close



Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/verify-email/{userid}/{verifyToken}', 'Auth\VerifyEmailController@verify_email');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'HomeController@profile');
Route::any('/send-otp', 'AjaxController@send_otp');
Route::post('/update-profile', 'HomeController@update_profile');
Route::post('/update-passwords', 'HomeController@update_passwords');
Route::post('/update-transaction-password', 'HomeController@update_transaction_password');


Route::get('/buy-package', 'HomeController@buy_package');
Route::any('/generate-qrcode', 'AjaxController@generate_qrcode');

Route::get('/transfer-to-holding-wallet', 'HomeController@transfer_to_holding_wallet');
Route::post('/transfer-to-holding-wallet', 'HomeController@transfer_amount_to_hw');

Route::get('/fix-plan', 'HomeController@fix_plan_details');
Route::get('/growth-plans', 'HomeController@growth_plans');
Route::any('/send-withdraw-otp', 'AjaxController@send_withdraw_otp');
Route::any('/send-transfer-otp', 'AjaxController@send_transfer_otp');

Route::post('/send-withdrawal-request', 'AjaxController@send_withdrawal_request');


Route::get('/direct-referrals', 'HomeController@direct_referrals');
Route::get('/downline', 'HomeController@downline_referrals');
Route::any('/get-referrals', 'AjaxController@get_referrals');
Route::any('/referral-income-report', 'HomeController@referral_income_report');
Route::get('/all-referrals', 'HomeController@all_referrals');


Route::get('/transfer-to-token-holding-wallet', 'HomeController@transfer_to_token_holding_wallet');
Route::post('/transfer-to-token-holding-wallet', 'HomeController@transfer_amount_to_thw');

Route::get('/generate-ticket', 'HomeController@generate_ticket');
Route::post('/add-query', 'HomeController@add_query');
Route::get('/view-tickets', 'HomeController@view_tickets');


Route::get('/withdraw-tokens', 'HomeController@withdraw_tokens');
Route::post('/withdraw-tokens', 'HomeController@withdraw_tokens_to_main_wallet');

Route::get('/withdraw-main-wallet', 'HomeController@withdraw_main_wallet');
Route::post('/withdraw-main-wallet', 'HomeController@withdraw_main_wallet_to_btc');

Route::get('/transfer-tokens', 'HomeController@transfer_tokens');
Route::post('/transfer-tokens', 'HomeController@transfer_tokens_to_other_user');
Route::post('/get-user-details', 'AjaxController@get_user_details');
Route::any('/check-payment-status', 'AjaxController@check_payment_status');
Route::any('/check-old-password', 'AjaxController@check_old_password');
Route::any('/check-transaction-password', 'AjaxController@check_transaction_password');


Route::get('/comming-soon', function(){
    return view('comming-soon');
});

//add by tarachand 
Route::get('/token-earning-report', 'HomeController@token_earning_report');
Route::get('/main-wallet-transaction', 'HomeController@main_wallet_transaction');
Route::get('/holding-wallet-transaction', 'HomeController@holding_wallet_transaction');
Route::get('/token-holding-report', 'HomeController@token_holding_report');
Route::get('/user-level-detail', 'HomeController@user_level_list');

// add by tarachand


//cron jobs
Route::get('/verify-deposit', 'CronController@verify_deposit');
Route::get('/generate-tokens', 'CronController@generate_tokens');

