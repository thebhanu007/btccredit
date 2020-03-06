@extends('layouts.layout')
@section('styles')
<style>
.notify .notify-body .notify-title{
  font-size:1.2rem !important;
}
.notify .notify-body .notify-text{
  font-size:1.4rem !important;
}
.loadersmall {
	border: 5px solid #f3f3f3;
    -webkit-animation: spin 1s linear infinite;
    animation: spin 1s linear infinite;
    border-top: 5px solid #555;
    border-radius: 50%;
    width: 25px;
    height: 25px;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
#payment_status{
	margin-top: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
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
        <h5 class="title">Deposit (Main Wallet)</h5>
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
    <div class="col-sm-12 text-right">
		<div class="col-sm-12">
			{{--<a href="{{url('/transfer-to-token-holding-wallet')}}" class="btn btn-primary">Transfer to Token Holding Wallet</a>--}}
		</div>
    </div>
	<div class="alert alert-danger col-sm-12 d-none amount-error">
                   
	</div>
              <form class="form-horizontal col-sm-12" id="package_purchase" role="form" method="post" action="{{ url('') }}/admin-panel/purchase-package-complete">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        				<div class="col-lg-8" style="margin-top:2%; float:left;">
										<div class="col-sm-5">
											<div class="notify success">
												<div class="notify-body">
												<div class="notify-title">Main Wallet Balance<img src="img/notification-success.svg" alt="" /></div>
												<div class="notify-text">${{Auth::user()->main_wallet_balance}}</div>
												</div>
											</div>
										</div>
	                                            <div class="form-group">
	                                                <label class="col-md-12 control-label">Enter Amount*</label>
	                                                <div class="col-md-12">
													<div class="input-group">
													<div class="input-group-prepend">
														<span class="input-group-text" id="basic-addon1">$</span>
													</div>
													<input type="text" class="form-control" @if(!empty($last_unpaid_transaction)) readonly @endif name="amount" id="amount" value="{{$last_unpaid_transaction->amount or ''}}">
													</div>
	                                                </div>
	                                            </div>
	                                            <div class="form-group">
	                                                <div class="col-md-2 col-md-offset-1">
                                                     <input type="button" class="btn btn-primary" id="submit-btn" value="Deposit Payment">
	                                                </div>
	                                            </div>
                        				</div>
										<div class="col-sm-4 float-left text-center" style="margin-top:4%;">
											<div class="card custom-default">
												<div class="card-header">
													<div class="card-title"><span class="notice-title @if(!empty($last_unpaid_transaction)) d-none @endif">Your bitcoin payment QR Code and address will be generated below after clicking.</span> <span class="payment-title @if(empty($last_unpaid_transaction)) d-none @endif">Pay &nbsp;<span id="bitcoins"> {{$last_unpaid_transaction->coins or ''}}</span> &nbsp;Using This QR Code :-</span> </div>
												</div>
												<div class="card-body"id="qrcodediv">
													<img src='{{$last_unpaid_transaction->qrcode_url or ""}}' id='barcode_btc'>
												</div>
												<div id="walletaddressbtc">
													{{$last_unpaid_transaction->address or ""}}
												</div>
												<div id="payment_status" class="@if(empty($last_unpaid_transaction)) d-none @endif" style="margin:10px 0px;">
													Your Payment is <div class="status" style="margin-top:5px;"><div class="loadersmall d-none"></div> <span class="badge badge-warning">Pending</span><span class="badge badge-success d-none">Success</span><span class="badge badge-danger d-none">Cancelled</span></div>
													<div class="d-none qr-suggestion text-danger font-weight-bold">Genrate New QR Code.</div>
													<div style="margin-top:10px;"><br>Payment page is auto refresh not need to reload / refresh.</div>
												</div>
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

@include('layouts.footer')





<script>
var check_deposit = "";
	@if(!empty($last_unpaid_transaction))
		check_deposit = setInterval(verify_deposit, 15000);
	@endif
			$("#submit-btn").click(function(e) {
				var amount = $("#amount").val(); 
				if(amount == ""){
					$("#amount").css("border-color", "red");
					$(".amount-error").removeClass("d-none");
					$(".amount-error").html("Please Enter Amount To Generate QR Code");
					return false;
				}
				if(parseInt(amount) < 10){
					$("#amount").css("border-color", "red");
					$(".amount-error").removeClass("d-none");
					$(".amount-error").html("Minimum deposit amount is $10.");
					return false;
				}
				else{
					$(".amount-error").addClass("d-none");
					$("#amount").css("border-color", "#e3e3e3");
				}
				$("#qrcodediv").html("Generating QR Code ...<br><img src='{{asset('/img/loader.gif')}}' width='100'>");
				$("#qrcodediv").css("display","block");
				var ajax_request = $.ajax({
				type: 'POST',  
				url : "{{url('')}}/generate-qrcode",
				data: {amount: amount},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
						success: function(result){
							result = JSON.parse(result);
						  if(result["error"] == "ok"){
							check_deposit = setInterval(verify_deposit, 15000);
							$("#payment_status").removeClass('d-none');
							$('.payment-title').removeClass('d-none');
							$('.notice-title').addClass('d-none');
							$("#qrcodediv").html("<img src='"+result["result"]["qrcode_url"]+"' id='barcode_btc'>");
							$("#walletaddressbtc").html(result["result"]["address"]);
							$("#bitcoins").html(result["result"]["amount"] + " BTC");
							$(".badge-warning").removeClass('d-none');
							$(".badge-success").addClass('d-none');
							$(".badge-danger").addClass('d-none');
							$("#amount").attr('disabled', true);
							$(".qr-suggestion").addClass("d-none");
						  }
						  else{
							 $("#qrcodediv").html("<span style='color:red'>"+result+"</span>");
							 $("#submit-btn").val("Retry");
							 $("#walletaddressbtc").html("");
							 $("#bitcoins").html("");
						  }
					}
				});
            });
			function verify_deposit(){
			$(".loadersmall").removeClass("d-none");
			$(".badge-warning").addClass("d-none");
			var ajax_request = $.ajax({
					type: 'POST',  
					url : "{{url('')}}/check-payment-status",
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
							success: function(result){
								$(".loadersmall").addClass("d-none");
								result = JSON.parse(result);
							if(result["status"] == "pending"){
								$(".badge-warning").removeClass('d-none');
								$(".badge-success").addClass('d-none');
								$(".badge-danger").addClass('d-none');
								$("#amount").attr('disabled', true);
								$(".qr-suggestion").addClass("d-none");
							}
							else if(result["status"] == "success"){
								clearInterval(check_deposit);
								$(".badge-warning").addClass('d-none');
								$(".badge-success").removeClass('d-none');
								$(".badge-danger").addClass('d-none');
								$("#amount").attr('disabled', false);
								$(".qr-suggestion").removeClass("d-none");
							}
							else if(result["status"] == "canceled"){
								clearInterval(check_deposit);
								$(".badge-warning").addClass('d-none');
								$(".badge-success").addClass('d-none');
								$(".badge-danger").removeClass('d-none');
								$("#amount").attr('disabled', false);
								$(".qr-suggestion").removeClass("d-none");
							}
						}
					});

	}

  </script>
@endsection
