@extends('admin/admin-layouts.app')

@section('content')
<body class="authentication">

<!-- Container start -->
<div class="container">
  
  <form action="{{ url('/admin/login') }}" method="post">
  {{ csrf_field() }}
    <div class="row justify-content-md-center">
      <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
        <div class="login-screen">
          <div class="login-box">
            <a href="#" class="login-logo">
            <img src="{{asset('img/BTC-Credit-Logo.png')}}" width="100">
            </a>
        {{--  <h5>Welcome back,<br />Please Login to your Account.</h5> --}}
            @if(Session::has('msg'))
                <div class="alert {{session('color')}}">
                    {{ Session::get('msg') }}
                </div>
            @endif
            <div class="form-group  {{ $errors->has('email') ? ' has-error' : '' }}">
              <input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email Address" />
              @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif

            </div>
            <div class="form-group  {{ $errors->has('password') ? ' has-error' : '' }}">
              <input type="password" class="form-control" placeholder="Password"  name="password" />
              @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
              @endif

            </div>
            <div class="actions">
              <button type="submit" class="btn btn-info">Login</button>
            </div>
            {{--
            <div class="m-0">
              <span class="additional-link">No account? <a href="{{ route('register') }}">Signup Now</a></span>
            </div>
            --}}
          </div>
        </div>
      </div>
    </div>
  </form>

</div>
<!-- Container end -->

</body>
@endsection
