@extends('layouts.layout')
@section('styles')
  <link rel="stylesheet" href="{{ asset('css/pricing.css')}}">
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
      <h5 class="title">Fix Plan</h5>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
    </div>
  </div>
</div>
<!-- Page header end -->


<!-- Content wrapper start -->
<div class="content-wrapper">


  <!-- Row start -->
  <div class="row gutters">
  @if (session('message'))
                <div class="alert {{session('alert')}} col-sm-12">
                    {{ session('message') }}
                </div>
  @endif

  @forelse($package_detail as $package)
    <div class="col-lg-4 col-md-4 col-sm-12">
      <div class="pricing-plan">
        <div class="pricing-header">
          <h4 class="pricing-title">Fix Plan</h4>
          <div class="pricing-cost">${{$package->amount_in_usd}}</div>
        </div>
        <ul class="pricing-features">
          <li>${{$package->amount_in_usd}} Added on {{date('M d, Y', strtotime($package->created_at))}}</li>
          @if($package->withdraw_status == 1)
          <li>${{$package->amount_in_usd}} Withdraw on {{date('M d, Y', strtotime($package->withdraw_date))}} at {{$package->deduction_percentage}}% deduction.</li>
          @endif

        </ul>
        <div class="pricing-footer">
        <?php 
          $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', date('Y-m-d H:i:s', strtotime($package->created_at)));
          $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', date('Y-m-d H:i:s'));
        ?>
        @if($package->withdraw_status == 0)
          <a href="javascript:;" class="btn btn-dark btn-lg withdraw-principal" data-toggle="modal" data-target="#withdraw-details" data-id="{{$package->id}}" data-amount="{{$package->amount_in_usd}}" data-months="{{$to->diffInMonths($from)}}">Withdraw</a>
        @endif
        </div>
      </div>
    </div>
    @empty
            <h2 class="text-center">
                No Records Found.
            </h2>
    @endforelse
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
      Deduction Amount :- <span class="model_deduction_amount"></span><br>
      Deduction Percentage :- <span class="model_deduction_percentage"></span><br>
      Withdrawable Amount :- <span class="model_withdrawal_amount"></span><br>
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
        <h5 class="modal-title" id="footerCenterIconsModalLabel">Withdraw Fix Plan Principal</h5>
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
            <form method="post" id="send-withdraw-request-form" action="{{url('/send-withdrawal-request')}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="holding_id" id="holding_id" value="0">
              <div class="form-group">
                  <label for="recipient-name" class="col-form-label">OTP</label>
                  <input type="text" class="form-control" id="input-withdrawal-otp">
              </div>
            </form>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-lighten" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary modal-request-withdrawal-btn">Request Withdrawal</button>
      </div>
    </div>
  </div>
</div>

@include('layouts.footer')
<script>
  $(".withdraw-principal").click(function(){
    var months = $(this).data('months');
    var amount = $(this).data('amount');
    var id = $(this).data('id');
    $("#holding_id").val(id)
    var deduction_percentage = 1;
    if(months == 0){
      deduction_percentage = 25;
    }
    else if(months == 1){
      deduction_percentage = 15;
    }
    else if(months == 2){
      deduction_percentage = 5;
    }
    var deduction_amount = amount * deduction_percentage / 100;
    var withdrawable_amount = amount - deduction_amount;
    $(".model_amount").html("$"+amount);
    $(".model_deduction_amount").html("$"+deduction_amount);
    $(".model_deduction_percentage").html(deduction_percentage+"%");
    $(".model_withdrawal_amount").html("$"+withdrawable_amount);
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
          $("#send-withdraw-request-form").submit();
        }
        else{
            $('#withdrawal-otp-error').removeClass('d-none');
            $('.otp-suggestions').addClass('d-none');
        }
    });
  
</script>
@endsection
