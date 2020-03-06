@extends('layouts.layout')
@section('styles')
<style>
    .help-block{
        color:red;
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
        <h5 class="title">Profile</h5>
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
	<div class="alert alert-danger col-sm-12 d-none profile-error">
                   
	</div>

    <form class="form-horizontal col-sm-12 " id="profile-form" role="form" method="post" action="{{url('/update-profile')}}">
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
       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                    <label class="col-md-12 control-label">First Name</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" required data-id="update-profile" id="first_name" name="first_name" value="{{Auth::user()->first_name}}">
                        @if ($errors->has('first_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('first_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group  {{ $errors->has('last_name') ? ' has-error' : '' }}">
                    <label class="col-md-12 control-label">Last Name</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" data-id="update-profile" id="last_name" name="last_name" value="{{Auth::user()->last_name}}">
                        @if ($errors->has('last_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-12 control-label">Email</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" data-id="update-profile" id="email" name="email" value="{{Auth::user()->email}}">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('phone_number') ? ' has-error' : '' }}">
                    <label class="col-md-12 control-label">Phone Number</label>
                    <div class="col-md-12">
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <select name="country_code" data-id="update-profile" class="form-control country-code">
                        <option value="91">+91 (IND)</option>
                        @foreach($countries as $country)
                            <option value="{{$country->phonecode}}" @if($country->phonecode == Auth::user()->country_code) selected @endif>+{{$country->phonecode}} ({{$country->iso3}})</option>
                        @endforeach
                        </select>
                        </div>
                        <input type="text" class="form-control" data-id="update-profile" placeholder="Phone Number" name="phone_number" value="{{ Auth::user()->phone_number }}" >
                        @if ($errors->has('phone_number'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone_number') }}</strong>
                        </span>
                        @endif
                    </div>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('btc_address') ? ' has-error' : '' }}">
                    <label class="col-md-12 control-label">BTC Address</label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" data-id="update-profile" id="btc_address" name="btc_address" value="{{Auth::user()->btc_address}}">
                        @if ($errors->has('btc_address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('btc_address') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-primary update-confirmation" disabled="true" data-form="profile" id="update-profile">Update Profile</button>
                    </div>
                </div>
    </form>
    <form class="form-horizontal col-sm-12 " id="password-form" role="form" method="post" action="{{url('/update-passwords')}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label class="col-md-12 control-label">Old Password</label>
                    <div class="col-md-12">
                        <input type="password" class="form-control" data-id="update-password" id="old_password" name="old_password" value="">
                    </div>
                </div>
                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="col-md-12 control-label">Password</label>
                    <div class="col-md-12">
                        <input type="password" class="form-control" data-id="update-password" id="password" name="password" value="">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 control-label">Retype Password</label>
                    <div class="col-md-12">
                    <input type="password" class="form-control"  name="password_confirmation" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-primary update-confirmation" data-form="password" disabled="true" id="update-password">Update Password</button>
                    </div>
                </div>
    </form>
    <form class="form-horizontal col-sm-12 " id="transaction-password-form" role="form" method="post" action="{{url('/update-transaction-password')}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group {{ $errors->has('transaction_password') ? ' has-error' : '' }}">
                    <label class="col-md-12 control-label">Transaction Password</label>
                    <div class="col-md-12">
                        <input type="password" class="form-control" data-id="update-transaction-password" id="transaction_password" name="transaction_password" value="">
                        @if ($errors->has('transaction_password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('transaction_password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12 control-label">Retype Transaction Password</label>
                    <div class="col-md-12">
                    <input type="password" class="form-control"  name="transaction_password_confirmation" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-primary update-confirmation" data-form="transaction-password" disabled="true" id="update-transaction-password">@if(Auth::user()->transaction_password == "")Add Password @else Update Password @endif</button>
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


<div class="modal fade" id="update-profile-otp-box" tabindex="-1" role="dialog" aria-labelledby="footerCenterIconsModalLabel" aria-hidden="true">
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
                                                <div class="alert alert-danger d-none" id="profile-otp-error">
                                                    Please Enter Correct OTP.
                                                </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">OTP</label>
                                                        <input type="text" class="form-control" id="input-profile-otp">
                                                    </div>
                                                </div>
												<div class="modal-footer justify-content-center">
													<button type="button" class="btn btn-lighten" data-dismiss="modal">Close</button>
													<button type="button" class="btn btn-primary modal-update-profile-btn">Update Profile</button>
												</div>
											</div>
										</div>
									</div>
                                    <div class="modal fade" id="update-password-otp-box" tabindex="-1" role="dialog" aria-labelledby="footerCenterIconsModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="footerCenterIconsModalLabel">OTP</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
                                                <div class="alert alert-success  otp-suggestions">
                                                    Enter OTP We Have Sent On {{Auth::user()->email}}.
                                                </div>
                                                <div class="alert alert-danger d-none" id="password-otp-error">
                                                    Please Enter Correct OTP.
                                                </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">OTP</label>
                                                        <input type="text" class="form-control" id="input-password-otp">
                                                    </div>
                                                </div>
												<div class="modal-footer justify-content-center">
													<button type="button" class="btn btn-lighten" data-dismiss="modal">Close</button>
													<button type="button" class="btn btn-primary modal-update-password-btn">Update Password</button>
												</div>
											</div>
										</div>
									</div>
                                    <div class="modal fade" id="update-transaction-password-otp-box" tabindex="-1" role="dialog" aria-labelledby="footerCenterIconsModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="footerCenterIconsModalLabel">OTP</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
                                                <div class="alert alert-success  otp-suggestions">
                                                    Enter OTP We Have Sent On {{Auth::user()->email}}.
                                                </div>
                                                <div class="alert alert-danger d-none" id="transaction-password-otp-error">
                                                    Please Enter Correct OTP.
                                                </div>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">OTP</label>
                                                        <input type="text" class="form-control" id="input-transaction-password-otp">
                                                    </div>
                                                </div>
												<div class="modal-footer justify-content-center">
													<button type="button" class="btn btn-lighten" data-dismiss="modal">Close</button>
													<button type="button" class="btn btn-primary modal-update-transaction-password-btn">Update Transaction Password</button>
												</div>
											</div>
										</div>
									</div>

@include('layouts.footer')



<script src="{{asset('js/btcvalid.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
<script>
     var otp = Math.floor(1000 + Math.random() * 9000);
    $(".form-control").keyup(function(){
        var id = $(this).data('id');
        $("#"+id).attr('disabled', false)
    })
    $("#profile-form").validate({
	rules: {
		first_name: {
			required: true,
			maxlength: 255,
		},
		last_name: {
			required: true,
			maxlength: 255,
		},
		email: {
			required: true,
            maxlength: 255,
            email:true
        },
		phone_number: {
			required: true,
            number: true,
        }
	}
    });
    $("#password-form").validate({
	rules: {
		password: {
			required: true,
			minlength: 6,
        },
        password_confirmation : {
			required: true,
            minlength : 6,
            equalTo : "#password"
        },
		old_password: {
			required: true,
            minlength: 6,
            remote: "/check-old-password"
		},
	},
    messages: {
        password: {
            required: "Enter Your New Password",
            minlength: "Password length should be at least 6 charecters.",
        },
        password_confirmation: {
            required: "Enter confirmation password",
            minlength: "Password length should be at least 6 charecters.",
            equalTo: "Enter correct confirm password."
        },
        old_password: {
            required: "Enter Your Old Password",
            minlength: "Password length should be at least 6 charecters.",
            remote: "Please enter correct old password.",
        },
    }
    });
    $("#transaction-password-form").validate({
	rules: {
		transaction_password: {
			required: true,
			minlength: 6,
        },
        transaction_password_confirmation : {
			required: true,
            minlength : 6,
            equalTo : "#transaction_password"
        },
	},
    messages: {
        transaction_password: {
            required: "Enter Your New Password",
            minlength: "Password length should be at least 6 charecters.",
        },
        transaction_password_confirmation: {
            required: "Enter confirmation password",
            minlength: "Password length should be at least 6 charecters.",
            equalTo: "Enter correct confirm password."
        },
    }
    });

$("#update-profile").click(function(){
    if (!$("#profile-form").validate()){
        return false;
    }
    else{
        var btc_address = $("#btc_address").val();
        if(!checkAddress(btc_address)){
            $("#btc_address").css("border-color", "red");
            $(".profile-error").removeClass("d-none");
            $(".profile-error").html("Please Enter Correct BTC Address.");
            return false;

        }
        else{
            $("#btc_address").css("border-color", "#c4c9da");
            $(".profile-error").addClass("d-none");
        }
        send_otp('profile');
    }
});
$("#update-password").click(function(){
    if (!$("#password-form").validate()){
        return false;
    }
    send_otp('password');
});
$("#update-transaction-password").click(function(){
    if (!$("#transaction-password-form").validate()){
        return false;
    }
    send_otp('transaction-password');
});
function send_otp(form){
    $('#loading-wrapper').show();
        var ajax_request = $.ajax({
				type: 'POST',  
				url : "{{url('')}}/send-otp",
				data: {otp: otp},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
						success: function(result){
                            $('#loading-wrapper').hide();
						  if(result == "success"){
                              if(form == "profile"){
                                $('#update-profile-otp-box').modal('show');     
                              }else if(form == "password"){
                                $('#update-password-otp-box').modal('show');     
                              }else{
                                $('#update-transaction-password-otp-box').modal('show');     
                              }          
                              console.log('OTP Sent to your email.');
						  }
						  else{
							 alert('something went wrong.');
						  }
					    }
            });
}
    /*$('.update-confirmation').click(function(){
    });*/
    $('.modal-update-profile-btn').click(function(){
        var input_otp = $("#input-profile-otp").val();
        if(input_otp == otp){
            $('#profile-form').submit();
        }
        else{
            $('#profile-otp-error').removeClass('d-none');
            $('.otp-suggestions').addClass('d-none');
        }
    });
    $('.modal-update-password-btn').click(function(){
        var input_otp = $("#input-password-otp").val();
        if(input_otp == otp){
            $('#password-form').submit();
        }
        else{
            $('#password-otp-error').removeClass('d-none');
            $('.otp-suggestions').addClass('d-none');
        }
    });
    $('.modal-update-transaction-password-btn').click(function(){
        var input_otp = $("#input-transaction-password-otp").val();
        if(input_otp == otp){
            $('#transaction-password-form').submit();
        }
        else{
            $('#transaction-password-otp-error').removeClass('d-none');
            $('.otp-suggestions').addClass('d-none');
        }
    });
  </script>
@endsection
