@extends('layouts.layout')
@section('styles')
<style>
.notify .notify-body .notify-title{
  font-size:1.2rem !important;
}
.notify .notify-body .notify-text{
  font-size:1.4rem !important;
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
        <h5 class="title">Withdraw Funds</h5>
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
    <div class="row gutters justify-content-center">
	@if (session('message'))
                <div class="alert {{session('alert')}} col-sm-12">
                    {{ session('message') }}
                </div>
	@endif  
	<div class="alert alert-danger col-sm-12 d-none amount-error">
                   
	</div>

    <form class="form-horizontal col-sm-4 " id="withdraw-main-wallet-form" role="form" method="post" action="{{url('/withdraw-main-wallet')}}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="mb-5">
                                            <h5 class="mb-3 text-center">------ Your BTC Address ------</h5>
                                            <div class="row gutters">
                                              <div class="col-xl-12">
                                                <button class="btn btn-primary btn-block">{{Auth::user()->btc_address}}</button>
                                                <ul style="list-style:disc; list-style-position:inside; margin:10px 0px;">
                                                  <li>Please Verify The Wallet Address. We Cannot Refund A Incorrect Withdrawal.</li>
                                                  <li>Minimum Withdrawal Amount : $10</li>
                                                </ul>
                                              </div>
                                            </div>
                                          </div>                                              
                                              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div class="notify success">
                                                  <div class="notify-body">
                                                  <div class="notify-title">Main Wallet Balance<img src="img/wallet.png" alt="" /></div>
                                                  <div class="notify-text">${{Auth::user()->main_wallet_balance}}</div>
                                                  </div>
                                                </div>
                                              </div>

	                                            <div class="form-group">
	                                                <label class="col-md-12 control-label">Enter Amount*</label>
	                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" name="amount" id="amount" value="{{ old('amount') }}">
	                                                </div>
	                                            </div>
	                                            <div class="form-group">
	                                                <label class="col-md-12 control-label">Transaction password*</label>
	                                                <div class="col-md-12">
                                                    <input type="password" class="form-control" name="transaction_password" id="transaction_password" value="">
	                                                </div>
	                                            </div>
	                                            <div class="form-group">
	                                                <div class="col-md-2 col-md-offset-1">
                                                     <button type="button" class="btn btn-primary withdraw-confirmation" id="submit-btn">Withdraw</button>
	                                                </div>
	                                            </div>
                                    </form>
                                      <!-- /.control-sidebar -->

    </div>
    <!-- Row end -->
  </div>
  <!-- Content wrapper end -->


</div>
<!-- *************
  ************ Main container end *************
  ************* -->
</div>

<div class="modal fade" id="withdraw-details" tabindex="-1" role="dialog" aria-labelledby="withdraw-details" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="footerCenterIconsModalLabel">Withdraw Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Amount :- <span class="model_amount"></span><br>
        BTC Address :- <span class="model_btc_address"></span><br>
        Note :- Please check your BTC address before withdraw your fund.
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-lighten" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary modal-send-withdraw-otp" >Confirm Withdraw</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="withdraw-otp-box" tabindex="-1" role="dialog" aria-labelledby="footerCenterIconsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="footerCenterIconsModalLabel">OTP</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success otp-suggestions">
            Enter OTP We Have Sent On {{Auth::user()->email}}.
        </div>
        <div class="alert alert-danger d-none" id="withdrawal-otp-error">
            Please Enter Correct OTP.
        </div>
              <div class="form-group">
                  <label for="recipient-name" class="col-form-label">OTP</label>
                  <input type="text" class="form-control" id="input-withdrawal-otp">
              </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-lighten" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary modal-request-withdrawal-btn">Request Withdrawal</button>
      </div>
    </div>
  </div>
</div>

@include('layouts.footer')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
<script>
      $("#withdraw-main-wallet-form").validate({
        rules: {
          amount: {
            required: true,
            number: true,
            min: 10
          },
          transaction_password: {
            required: true,
            minlength: 6,
            remote: "/check-transaction-password"
          },
        },
      messages: {
        amount: {
            required: "Please Enter Amount To Withdrawal.",
            number: "Please Enter Correct Amount.",
            min: "Minimum Withdrawal amount is $10.",
        },
        transaction_password: {
            required: "Enter Your Old Password",
            minlength: "Password length should be at least 6 charecters.",
            remote: "Please enter correct transaction password.",
        },
    }
      });

  $(".withdraw-confirmation").click(function(){
    var amount = $("#amount").val();
    if (!$("#withdraw-main-wallet-form").validate()){
        return false;
    }
    else{
      $(".model_amount").html("$"+amount);
      $(".model_btc_address").html('{{Auth::user()->btc_address}}');
      $('#withdraw-details').modal('show');     
    }
  });
  var otp = Math.floor(1000 + Math.random() * 9000);
    $('.modal-send-withdraw-otp').click(function(){
      $('#loading-wrapper').show();
        var ajax_request = $.ajax({
				type: 'POST',  
				url : "{{url('')}}/send-withdraw-otp",
				data: {otp: otp},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
			    success: function(result){
              $('#loading-wrapper').hide();
						  if(result == "success"){
                $('#withdraw-details').modal('hide');               
                $('#withdraw-otp-box').modal('show');               
						  }
						  else{
							 alert('something went wrong.');
						  }
					    }
            });
    });
    $('.modal-request-withdrawal-btn').click(function(){
      var input_otp = $("#input-withdrawal-otp").val();
      var holding_id = $(this).data('holdingid');
        if(input_otp == otp){
          $("#withdraw-main-wallet-form").submit();
        }
        else{
            $('#withdrawal-otp-error').removeClass('d-none');
            $('.otp-suggestions').addClass('d-none');
        }
    });
  
</script>
@endsection
