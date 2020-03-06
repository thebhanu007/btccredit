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
        <h5 class="title">Generate Ticket</h5>
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

    <form class="form-horizontal col-sm-12 " id="add-query-form" role="form" method="post" action="{{url('/add-query')}}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
	                                            <div class="form-group">
	                                                <label class="col-md-12 control-label">Select Subject*</label>
	                                                <div class="col-md-12">
                                                    <select class="form-control" name="subject" id="subject">
                                                        <option value="Accounts">Accounts</option>
                                                        <option value="General">General</option>
                                                        <option value="Complaint">Complaint</option>
                                                        <option value="Technical">Technical</option>
                                                        <option value="Other">Other</option>                                                    </select>
	                                                </div>
	                                            </div>
	                                            <div class="form-group">
	                                                <label class="col-md-12 control-label">Enter Your Query*</label>
	                                                <div class="col-md-12">
                                                        <textarea class="form-control" name="content" id="content"></textarea>
	                                                </div>
	                                            </div>
	                                            <div class="form-group">
	                                                <div class="col-md-2 col-md-offset-1">
                                                     <button type="submit"  class="btn btn-primary" id="submit-btn">Submit Your Query</button>
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
@endsection
