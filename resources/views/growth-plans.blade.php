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
      <h5 class="title">Growth Plans</h5>
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
    @forelse($packages_detail as $package)
    <div class="col-lg-4 col-md-4 col-sm-12">
      <div class="pricing-plan">
        <div class="pricing-header">
          <h4 class="pricing-title">Growth Plan</h4>
          <div class="pricing-cost">${{$package->amount_in_usd}}</div>
          <div class="pricing-save">Reveived ${{$package->roi_generated}}</div>
        </div>
        <ul class="pricing-features">
            <li>${{$package->amount_in_usd}} Added on {{date('M d, Y', strtotime($package->created_at))}}</li>
        </ul>
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

@include('layouts.footer')
@endsection
