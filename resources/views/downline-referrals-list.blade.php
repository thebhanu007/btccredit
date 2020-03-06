@extends('layouts.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/tree.css')}}" />
<style>
#myListTree ul {
    margin-block-start: 5px;
    margin-block-end: 5px;
    margin-inline-end: 0px;
    margin-inline-start: 40px;
    border-left: 1px solid gray;
}

#myListTree ul li{
    margin-top: 5px;
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
      <h5 class="title">Direct referrals List</h5>
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
                <div class="alert {{session('alert')}}">
                    {{ session('message') }}
                </div>
  @endif
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  <div class="card">
								<div class="card-body">
									
									<!--*************************
										*************************
										*************************
										Basic table start
									*************************
									*************************
									*************************-->
                                    <div id="myListTree">
                                      <ul class="tv-ul">
                                        <li data-haschild="true" data-isloaded="false"><span class="tv-caret" data-id="{{Auth::user()->userid}}">{{Auth::user()->first_name}} ({{Auth::user()->userid}})</span></li>
                                      </ul>
                                    </div>
									<!--*************************
										*************************
										*************************
										Basic table end
									*************************
									*************************
									*************************-->

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

@include('layouts.footer')
@endsection

@section('scripts')
<script src="{{asset('js/tree.js')}}" type="text/javascript"></script>
<script>
  $('#myListTree').tree({
  onDemandData: function (userid) {
  }
});

  </script>
@endsection