@extends('layouts.app')

@section('content')
<body class="authentication">

<!-- Container start -->
<div class="container">
@if (session('status'))
      <div class="alert alert-success">
          {{ session('status') }}
      </div>
@endif
  
<form method="post" action="{{ route('password.email') }}">
      {{ csrf_field() }}
    <div class="row justify-content-md-center">
      <div class="col-xl-5 col-lg-5 col-md-6 col-sm-12">
        <div class="login-screen">
          <div class="login-box">
            <a href="#" class="login-logo">
            <span class="text-danger">B</span><span class="text-warning">T</span><span class="text-success">C</span><span class="text-info">C</span>
            </a>
            <h5 class="mr-5">In order to access your dashboard, please enter the email id you provided during the registration process.</h5>
            <div class="form-group  {{ $errors->has('email') ? ' has-error' : '' }}">
              <input type="text" class="form-control" placeholder="Enter Email Address" name="email" value="{{ old('email') }}" />
            </div>
            <div class="actions">
              <button type="submit" class="btn btn-danger btn-lg">Submit</button>
            </div>
            <p class="mt-3 mb-1">
        <a href="{{route('login')}}">Login</a>
      </p>
      <p class="mb-0">
        <a href="{{route('register')}}" class="text-center">Register a new membership</a>
      </p>

          </div>
          
        </div>


      </div>
    </div>
  </form>
</div>
<!-- Container end -->

</body>




@endsection
