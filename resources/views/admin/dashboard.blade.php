@extends('admin/admin-layouts.layout')
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
@include('admin/admin-layouts.header')
<!-- Header end -->



<!-- Navigation start -->
@include('admin/admin-layouts.navigation')
<!-- Navigation end -->
<div class="main-container">
  <!-- Page header start -->
  <div class="page-title">
    <div class="row gutters">
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <h5 class="title">Welcome back</h5>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="input-group">
        </div>
			</div>
      
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
      <div class="notify success">
        <div class="notify-body">
          <div class="notify-title">Total Users<img src="img/notification-success.svg" alt="" /></div>
          <div class="notify-text">{{$user->total_users}}</div>
        </div>
      </div>
		</div>
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
      <div class="notify success">
        <div class="notify-body">
          <div class="notify-title">Total Deposite Amount<img src="img/notification-danger.svg" alt="" /></div>
          <div class="notify-text">{{$deposite->total_deposite or '$0'}}</div>
        </div>
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
@include('admin/admin-layouts.footer')
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
