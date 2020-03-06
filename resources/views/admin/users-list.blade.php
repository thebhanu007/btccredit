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
			<div class="table-responsive">
				<table id="basicExample" class="table m-0">
					<thead>
						<tr>
							<th>S. No.</th>
							<th>Name</th>
							<th>Email</th>
							<th>Main Wallet Balance</th>
							<th>Phone</th>
							<th>Total Joining</th>
							<th>Joining Date</th>
						</tr>
					</thead>
					<tbody>
					@foreach($users as $key => $user)
						<tr>
							<td>{{++$key}}</td>
							<td>{{$user->first_name}} {{$user->last_name}}</td>
							<td>{{$user->email}}</td>
							<td><button type="button"  data-toggle="modal" data-target="#footerCenterIconsModal{{$user->id}}" class="btn btn-primary transfer-confirmation" id="submit-btn">Wallet Balance</button>
							<div class="modal fade" id="footerCenterIconsModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="footerCenterIconsModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="footerCenterIconsModalLabel">Wallet Balance</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<table class="table table-bordered">
											<tr>
												<th>Main Wallet Balance</th>
												<td>{{$user->main_wallet_balance}}</td>
											</tr>
											<tr>
												<th>Token Wallet Balance</th>
												<td>{{$user->token_wallet_balance}}</td>
											</tr>
											<tr>
												<th>Fix Holding Wallet Balance</th>
												<td>{{$user->fix_holding_wallet_balance}}</td>
											</tr>
											<tr>
												<th>Growth Holding Wallet Balance</th>
												<td>{{$user->growth_holding_wallet_balance}}</td>
											</tr>
											<tr>
												<th>Token Holding Wallet Balance</th>
												<td>{{$user->token_holding_wallet_balance}}</td>
											</tr>
										</table>
									</div>
									<div class="modal-footer justify-content-right">
										<button type="button" class="btn btn-lighten" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>
							</td>
							<td>{{$user->phone_number}} </td>
							<td>{{$user->total_refer}} </td>
							<td>{{date('M d, Y', strtotime($user->created_at))}}</td>
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