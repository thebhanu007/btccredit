@extends('layouts.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bs4.css')}}" />
<link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bs4-custom.css')}}" />
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
      <h5 class="title">All Referrals List</h5>
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
									<div class="table-responsive">
										<table id="all-level" class="table m-0">
											<thead>
												<tr>
                                                    <th>User Id</th>
                                                    <th>Name</th>
													<th>Email</th>
													<th>Holding Wallet Balance</th>
													<th>Token Holding Wallet Balance</th>
													<th>Email Verification</th>
													<th>Joining Date</th>
                                                    <th>Level</th>
												</tr>
											</thead>
											<tbody>
                                            @foreach($direct_referrals_records as $key => $referrals)
                                                @foreach($referrals as $key2 => $referral)
												<tr>
                                                    <td>{{$referral->userid}}</td>
                                                    <td>{{$referral->first_name}} {{$referral->last_name}}</td>
													<td>{{$referral->email}}</td>
													<td>${{$referral->fix_holding_wallet_balance + $referral->growth_holding_wallet_balance}}</td>
													<td>{{$referral->token_holding_wallet_balance}} Tokens</td>
													<td>@if($referral->email_verified == 1) <span class="badge badge-success">Verified</span> @else <span class="badge badge-danger">Not Verified @endif</span></td>
													<td>{{date('M d, Y', strtotime($referral->created_at))}}</td>
                                                    <td>{{$key}}</td>
												</tr>
                                                @endforeach
                                            @endforeach
											</tbody>
							    	</table>
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
		<!-- Data Tables -->
		<script src="{{asset('vendor/datatables/dataTables.min.js')}}"></script>
		<script src="{{asset('vendor/datatables/dataTables.bootstrap.min.js')}}"></script>
		
		<!-- Custom Data tables -->
		<script src="{{asset('vendor/datatables/custom/custom-datatables.js')}}"></script>
		<script src="{{asset('vendor/datatables/custom/fixedHeader.js')}}"></script>

@endsection