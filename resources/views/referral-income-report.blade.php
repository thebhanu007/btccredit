@extends('layouts.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bs4.css')}}" />
<link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bs4-custom.css')}}" />
@endsection

@section('content')
<div class="container">
<!-- Header start -->
@include('layouts.header')
<!-- Header end -->
<!-- Navigation start -->
@include('layouts.navigation')
<!-- Navigation end -->
  <div class="main-container">
<div class="page-title">
  <div class="row gutters">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
      <h5 class="title">Referral Income Transaction</h5>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
    </div>
  </div>
</div>
<div class="content-wrapper">
  <div class="row gutters">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  <div class="card">
		<div class="card-body">
			<div class="table-responsive">
				<table id="basicExample" class="table m-0">
					<thead>
						<tr>
							<th>S. No.</th>
							<th>Amount</th>
							<th>Tokens</th>
							<th>Commission For</th>
							<th>Level</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
					@foreach($referral_income_reports as $key => $report)
						<tr>
							<td>{{++$key}}</td>
							<td>${{$report->usd}}</td>
							<td>{{$report->tokens}} Tokens</td>
							<td>{{$report->commission_for}}</td>
							<td>{{$report->level}}</td>
							<td>{{date('M d, Y', strtotime($report->created_at))}}</td>
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

@include('layouts.footer')
@endsection

@section('scripts')
		<!-- Data Tables -->
		<script src="{{asset('vendor/datatables/dataTables.min.js')}}"></script>
		<script src="{{asset('vendor/datatables/dataTables.bootstrap.min.js')}}"></script>
		
		<!-- Custom Data tables -->
		<script src="{{asset('vendor/datatables/custom/custom-datatables.js')}}"></script>
		<script src="{{asset('vendor/datatables/custom/fixedHeader.js')}}"></script>

@endsection