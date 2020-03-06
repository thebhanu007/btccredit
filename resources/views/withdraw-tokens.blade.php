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

    <form class="form-horizontal col-sm-3 " id="withdraw-tokens-form" role="form" method="post" action="{{url('/withdraw-tokens')}}">
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
	                                                <label class="col-md-12 control-label">Enter Tokens*</label>
	                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" name="tokens" id="tokens" value="">
	                                                </div>
	                                            </div>
	                                            <div class="form-group">
	                                                <div class="col-md-2 col-md-offset-1">
                                                     <button type="button"  data-toggle="modal" data-target="#footerCenterIconsModal" class="btn btn-primary withdraw-confirmation" id="submit-btn">Withdraw</button>
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


<div class="modal fade" id="footerCenterIconsModal" tabindex="-1" role="dialog" aria-labelledby="footerCenterIconsModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="footerCenterIconsModalLabel">Withdraw Tokens</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
                                                    Tokens :- <span class="model_tokens"></span><br>
                                                    Total USD :- <span class="model_amount"></span><br>
                                                    Token Rate :- <span class="model_token_rate"></span><br>
												</div>
												<div class="modal-footer justify-content-center">
													<button type="button" class="btn btn-lighten" data-dismiss="modal">Close</button>
													<button type="button" class="btn btn-primary modal-withdraw-tokens">Withdraw</button>
												</div>
											</div>
										</div>
									</div>

@include('layouts.footer')





<script>
			$('.withdraw-confirmation').click(function(){
				var tokens = $("#tokens").val(); 
				if(tokens == ""){
					$("#amount").css("border-color", "red");
					return false;
				}
                var token_rate = {{$token_rate->token_price}};
                var usd = tokens*token_rate;
				$(".model_tokens").html(tokens+" tokens");
				$(".model_amount").html("$"+usd);
				$(".model_token_rate").html("1 token = $"+token_rate);
			});
			$('.modal-withdraw-tokens').click(function(){
				$('#withdraw-tokens-form').submit();
			})
  </script>
@endsection
