@extends('admin/admin-layouts.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bs4.css')}}" />
<link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bs4-custom.css')}}" />
@endsection

@section('content')
<div class="container">
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
      <h5 class="title">Main Wallet Withdrawal Requests</h5>
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
			<div class="table-responsive">
				<table id="basicExample" class="table m-0">
					<thead>
						<tr>
							<th>S. No.</th>
							<th>User ID</th>
							<th>User Name</th>
							<th>Email</th>
							<th>Amount</th>
							<th>Bitcoin Address</th>
							<th>Requested Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					@foreach($requests as $key => $request)
						<tr>
							<td>{{++$key}}</td>
							<td>{{$request->userid}} </td>
							<td>{{$request->first_name}} {{$request->last_name}}</td>
							<td>{{$request->email}}</td>
							<td>${{$request->usd}}</td>
							<td>{{$request->btc_address}} </td>
							<td>{{date('M d, Y', strtotime($request->created_at))}}</td>
							<td>
								<a href="#" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Approve" aria-describedby="tooltip996065"><i class="icon-check"></i></a>
								<a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Decline" aria-describedby="tooltip996065"><i class="icon-close"></i></a>
							</td>
						</tr>

					@endforeach
					</tbody>
			</table>
			</div>
		</div>
	</div>

  </div>
  </div>
  <!-- Row end -->


</div>
<!-- Content wrapper end -->
</div>
</div>

@include('admin/admin-layouts.footer')
@endsection

@section('scripts')
		<!-- Data Tables -->
		<script src="{{asset('vendor/datatables/dataTables.min.js')}}"></script>
		<script src="{{asset('vendor/datatables/dataTables.bootstrap.min.js')}}"></script>
		
		<!-- Custom Data tables -->
		<script src="{{asset('vendor/datatables/custom/custom-datatables.js')}}"></script>
		<script src="{{asset('vendor/datatables/custom/fixedHeader.js')}}"></script>

@endsection