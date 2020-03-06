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
      <h5 class="title">Tickets</h5>
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
										<table id="basicExample" class="table m-0">
											<thead>
												<tr>
                                                    <th>S. No.</th>
                                                    <th>Ticket Id</th>
													<th>Subject</th>
													<th>Query</th>
													<th>Status</th>
													<th>Date</th>
												</tr>
											</thead>
											<tbody>
                                            @forelse($alltickets as $key => $ticket)
												<tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$ticket->ticket_id}}</td>
													<td>{{$ticket->subject}}</td>
													<td>{{$ticket->content}}</td>
													<td>{{$ticket->status}}</td>
													<td>{{date('M d, Y', strtotime($ticket->created_at))}}</td>
												</tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6">No Tickets Found.</td>
                                                </tr>
                                            @endforelse
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