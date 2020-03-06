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
        <h5 class="title">Transfer To Token Holding Wallet</h5>
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
    <div class="alert alert-danger col-sm-12 d-none display-errors">
                   
    </div>
    <div class="col-sm-12 text-right">
		<div class="col-sm-12">
			<a href="{{url('/withdraw-tokens')}}" class="btn btn-primary">Withdraw Tokens</a>
		</div>
    </div>

    <form class="form-horizontal col-sm-3 " id="transfer-form" role="form" method="post" action="{{url('/transfer-tokens')}}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
										<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
											<div class="notify success">
												<div class="notify-body">
												<div class="notify-title">Token Wallet Balance<img src="img/wallet-orange.png" alt="" /></div>
												<div class="notify-text">{{Auth::user()->token_wallet_balance}} Tokens</div>
												</div>
											</div>
										</div>
                                                <div class="form-group">
	                                                <label class="col-md-12 control-label">Enter User ID*</label>
	                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" name="userid" id="userid" value="">
	                                                </div>
	                                            </div>
                                                <div class="form-group">
	                                                <label class="col-md-12 control-label">User Name*</label>
	                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" readonly id="username" value="">
	                                                </div>
	                                            </div>
	                                            <div class="form-group">
	                                                <label class="col-md-12 control-label">Enter Tokens*</label>
	                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" name="tokens" id="tokens" value="">
	                                                </div>
	                                            </div>
	                                            <div class="form-group">
	                                                <div class="col-md-2 col-md-offset-1">
                                                     <button type="button"  data-toggle="modal" data-target="#transfer-otp-box" class="btn btn-primary transfer-confirmation" id="submit-btn">Transfer</button>
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


<div class="modal fade" id="transfer-otp-box" tabindex="-1" role="dialog" aria-labelledby="footerCenterIconsModalLabel" aria-hidden="true">
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
        <div class="alert alert-danger d-none" id="transfer-otp-error">
            Please Enter Correct OTP.
        </div>
              <div class="form-group">
                  <label for="recipient-name" class="col-form-label">OTP</label>
                  <input type="text" class="form-control" id="input-transfer-otp">
              </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-lighten" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary modal-request-transfer-btn">Request Withdrawal</button>
      </div>
    </div>
  </div>
</div>

@include('layouts.footer')





<script>
            $('#userid').blur(function(){
                var id = $(this).val();
                $('#loading-wrapper').show();
                    var ajax_request = $.ajax({
                            type: 'POST',  
                            url : "{{url('')}}/get-user-details",
                            data: {id: id},
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(result){
                                $('#loading-wrapper').hide();
                                var jsonresult = JSON.parse(result);
                                    if(jsonresult){
                                        $('#username').val(jsonresult.first_name+" "+jsonresult.last_name);
                                            //$('#withdraw-details').modal('hide');               
                                    }
                                    else{
                                        alert('User Id not found.');
                                    }
                                    }
                        });
            });
    var otp = Math.floor(1000 + Math.random() * 9000);
    $('.transfer-confirmation').click(function(){
        var tokens = $('#tokens').val();
        if(tokens > {{Auth::user()->token_wallet_balance}}){
            $(".display-errors").removeClass('d-none');
            $(".display-errors").html('Token wallet balance is not enough.');
            return;
        }
        var ajax_request = $.ajax({
				type: 'POST',  
				url : "{{url('')}}/send-transfer-otp",
				data: {otp: otp},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
						success: function(result){
						  if(result == "success"){
                              console.log('OTP Sent to your email.');
						  }
						  else{
							 console.log('something went wrong.');
						  }
					    }
            });
    });
    $('.modal-request-transfer-btn').click(function(){
        var input_otp = $("#input-transfer-otp").val();
        if(input_otp == otp){
            $('#transfer-form').submit();
        }
        else{
            $('#transfer-otp-error').removeClass('d-none');
            $('.otp-suggestions').addClass('d-none');
        }
    });
  </script>
@endsection
