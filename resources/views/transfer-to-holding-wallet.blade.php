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
        <h5 class="title">Transfer To Holding Wallet</h5>
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

    <form class="form-horizontal col-sm-12 " id="transfer-to-holding-wallet-form" role="form" method="post" action="{{url('/transfer-to-holding-wallet')}}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
												<div class="col-sm-3">
													<div class="notify success">
														<div class="notify-body">
														<div class="notify-title">Main Wallet Balance<img src="img/notification-success.svg" alt="" /></div>
														<div class="notify-text">${{Auth::user()->main_wallet_balance}}</div>
														</div>
													</div>
												</div>
	                                            <div class="form-group">
	                                                <label class="col-md-12 control-label">Select Package*</label>
	                                                <div class="col-md-12">
                                                    <select class="form-control" name="package_type" id="package_type">
                                                        <option value="Fix">Fix Plan (You Can Withdraw You Principle Any Time*)</option>
                                                        <option value="Growth">Growth Plan(You Will Get More Percentage So That You Can Get More Tokens Before The Price Increase)</option>
                                                    </select>
	                                                </div>
	                                            </div>
												<div class="table-responsive col-sm-12">
													<table id="basicExample" class="table m-0">
															<tr>
																<th>Investment</th>
																<th>FixPlan (Principal Withdraw Any Time*)</th>
																<th>GrowthPlan (Principle + Interest)</th>
															</tr>
															<tr>
																<td>$150 - $500</td>
																<td>5%</td>
																<td>12%</td>
															</tr>
															<tr>
																<td>$501 - $1500</td>
																<td>5.50%</td>
																<td>13%</td>
															</tr>
															<tr>
																<td>$1501 - $3000</td>
																<td>6%</td>
																<td>14%</td>
															</tr>
															<tr>
																<td>$3001 - $7500</td>
																<td>6.50%</td>
																<td>15%</td>
															</tr>
															<tr>
																<td>$7501 - $15000</td>
																<td>7%</td>
																<td>16%</td>
															</tr>
															<tr>
																<td>$15001 - $25000</td>
																<td>7.50%</td>
																<td>17%</td>
															</tr>
															<tr>
																<td>Above $25000</td>
																<td>8%</td>
																<td>18%</td>
															</tr>
												</table>
											</div>
												<ul class="col-sm-12" style="list-style:disc; list-style-position:inside; margin:20px 0px;">
													<li>All % are on monthly basis & Will be credited in wallet daily as per token price.</li>
													<li>In Fix Plan*Principal Withdrawal in 1st month: 25% deduction , 2ndMonth: 15% , 3rd Month: 5% , 4th month onwards 1%.</li>
													<li>In Growth Plan Principle cannot be withdrawn anytime during the contract. ROI will be received till the investment amount becomes double.</li>
												</ul>
	                                            <div class="form-group">
	                                                <label class="col-md-12 control-label">Enter Amount*</label>
	                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" name="amount" id="amount" value="">
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
                                                     <button type="button" class="btn btn-primary transfer-confirmation" id="submit-btn">Transfer</button>
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
													<h5 class="modal-title" id="footerCenterIconsModalLabel">Transfer to Holding Wallet</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													Package Type :- <span class="model_package_type"></span><br>
													Amount :- <span class="model_amount"></span><br>
												</div>
												<div class="modal-footer justify-content-center">
													<button type="button" class="btn btn-lighten" data-dismiss="modal">Close</button>
													<button type="button" class="btn btn-primary modal-transfer-to-holding-wallet">Transfer</button>
												</div>
											</div>
										</div>
									</div>

@include('layouts.footer')


<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>



<script>
      $("#transfer-to-holding-wallet-form").validate({
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

			$('.transfer-confirmation').click(function(){
				if (!$("#transfer-to-holding-wallet-form").validate()){
					return false;
				}
				else{
					var package_type = $("#package_type").val();
					var amount = $("#amount").val();
					$(".model_package_type").html(package_type+" Plan");
					$(".model_amount").html("$"+amount);
					$('#footerCenterIconsModal').modal('show');     
				}
			});
			$('.modal-transfer-to-holding-wallet').click(function(){
				$('#transfer-to-holding-wallet-form').submit();
			})
  </script>
@endsection
