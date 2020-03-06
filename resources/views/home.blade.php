@extends('layouts.layout')
@section('styles')
<style>
.notify .notify-body .notify-title{
  font-size:1.2rem !important;
  color:#2e323c;
}
.notify .notify-body .notify-text{
  font-size:1.4rem !important;
  color:#2e323c;
}
</style>
@endsection
@section('content')
<div class="container">


<!-- *************
  ************ Header section start *************
  ************* -->


<!-- Header start -->
@include('layouts.header')
<!-- Header end -->



<!-- Navigation start -->
@include('layouts.navigation')
<!-- Navigation end -->





<!-- *************
  ************ Header section end *************
  ************* -->







<!-- *************
  ************ Main container start *************
  ************* -->
<div class="main-container">


  <!-- Page header start -->
  <div class="page-title">
    <div class="row gutters">
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <h5 class="title">Welcome back, {{Auth::user()->first_name}}</h5>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
      
      </div>
    </div>
  </div>
  <!-- Page header end -->


  <!-- Content wrapper start -->
  <div class="content-wrapper">


    <!-- ************************** Visitors and Revenue ************************** -->
    <!-- Row start -->
    <div class="row gutters justify-content-left">
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
    <a href="{{url('/main-wallet-transaction')}}">
      <div class="notify success">
        <div class="notify-body">
          <div class="notify-title">Main Wallet <br>Balance<img src="img/wallet.png" alt="" /></div>
          <div class="notify-text">${{Auth::user()->main_wallet_balance}}</div>
        </div>
      </div>
    </a>
		</div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
    <a href="{{url('/holding-wallet-transaction')}}">
      <div class="notify success">
        <div class="notify-body">
          <div class="notify-title">Fix Holding Wallet <br>Balance<img src="img/wallet-red.png" alt="" /></div>
          <div class="notify-text">${{Auth::user()->fix_holding_wallet_balance}}</div>
        </div>
      </div>
    </a>
		</div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
    <a href="{{url('/holding-wallet-transaction')}}">
      <div class="notify success">
        <div class="notify-body">
          <div class="notify-title">Growth Holding Wallet <br>Balance<img src="img/wallet-green.png" alt="" /></div>
          <div class="notify-text">${{Auth::user()->growth_holding_wallet_balance}}</div>
        </div>
      </div>
    </a>
		</div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
    <a href="{{url('/token-earning-report')}}">
      <div class="notify success">
        <div class="notify-body">
          <div class="notify-title">Token Wallet <br>Balance<img src="img/wallet-orange.png" alt="" /></div>
          <div class="notify-text">{{Auth::user()->token_wallet_balance}} Tokens</div>
        </div>
      </div>
    </a>
		</div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
    <a href="{{url('/token-holding-report')}}#">
      <div class="notify success">
        <div class="notify-body">
          <div class="notify-title">Token Holding Wallet <br>Balance<img src="img/wallet-yellow.png" alt="" /></div>
          <div class="notify-text">{{Auth::user()->token_holding_wallet_balance}} Tokens</div>
        </div>
      </div>
    </a>
		</div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
    <a href="{{url('/direct-referrals')}}">
      <div class="notify success">
        <div class="notify-body">
          <div class="notify-title">Direct <br>Referrals<img src="img/refer.png" alt="" /></div>
          <div class="notify-text">{{$userdetail->referrals}}</div>
        </div>
      </div>
    </a>
		</div>
    </div>
    <div class="form-group col-sm-12">
        <div class="input-group">
          <div class="input-group-prepend">
							<span class="input-group-text">Your Referral Link</span>
						</div>
            <input type="text" class="form-control" value="{{url('/register?referrer_id=')}}{{Auth::user()->userid}}" id="referral_link" readonly>          <div class="input-group-append">
            <button class="btn btn-outline-primary" type="button" id="copy-btn" onclick="copytoclipboard();">Copy</button>
          </div>
        </div>
			</div>

    <!-- Row end -->
  </div>
  <!-- Content wrapper end -->


</div>
<!-- *************
  ************ Main container end *************
  ************* -->


</div>
@include('layouts.footer')
<script>
function copytoclipboard() {
  /* Get the text field */
  var copyText = document.getElementById("referral_link");

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

  /* Copy the text inside the text field */
  document.execCommand("copy");
  document.getElementById('copy-btn').innerHTML="Copied";

}
</script>

@endsection
