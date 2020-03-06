@extends('admin/admin-layouts.layout')

@section('content')
<div class="container">
@include('admin/admin-layouts.header')
@include('admin/admin-layouts.navigation')
<div class="main-container">
  <div class="page-title">
    <div class="row gutters">
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
        <h5 class="title">Token Price</h5>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
      </div>
    </div>
  </div>
  <div class="content-wrapper">
    <div class="row gutters justify-content-center">
    <div class="col-sm-12 text-right">
    </div>
			@if(Session::has('msg'))
                <div class="alert {{session('color')}} col-sm-12" align="center">
                    {{ Session::get('msg') }}
                </div>
            @endif
              <form class="form-horizontal col-sm-12" role="form" method="post" action="{{ url('/admin/token-price-update') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="col-lg-8" style="margin-top:2%; float:left;">
								<div id="useriddiv"> 
								</div>
								<div class="form-group">
									<label class="col-md-12 control-label">Enter One Token Price in USD*</label>
									<div class="col-md-12">
									<input type="text" class="form-control" name="amount" id="amount" value="">
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-2 col-md-offset-1">
										<input type="submit" class="btn btn-primary" id="submit-btn" value="Update Price">
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
</div>
@include('admin/admin-layouts.footer')
@endsection
