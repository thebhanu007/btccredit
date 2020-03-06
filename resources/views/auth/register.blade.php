@extends('layouts.app')
@section('styles')
		<link rel="stylesheet" type="text/css" href="{{asset('css/jquery.ccpicker.css')}}">
@endsection
@section('content')
<body class="authentication">

<!-- Container start -->
<div class="container">
  <form action="{{ route('register') }}" method="post">
  {{ csrf_field() }}
    <div class="row justify-content-md-center">
      <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12">
        <div class="login-screen">
          <div class="login-box">
          @if (session('message'))
                <div class="alert {{session('alert')}}">
                    {{ session('message') }}
                </div>
          @endif  
            <a href="#" class="login-logo">
            <img src="{{asset('img/BTC-Credit-Logo.png')}}" width="100">
            </a>
            <h5>Welcome,<br />Create your Admin Account.</h5>
            <div class="form-group  {{ $errors->has('referrer_id') ? ' has-error' : '' }}">
              <input type="text" class="form-control" placeholder="Referral ID" name="referrer_id"  value="{{app('request')->input('referrer_id')}}" />
              @if ($errors->has('referrer_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('referrer_id') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group  {{ $errors->has('first_name') ? ' has-error' : '' }}">
              <input type="text" class="form-control" placeholder="First Name" name="first_name"  value="{{ old('first_name') }}" />
              @if ($errors->has('first_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('first_name') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group  {{ $errors->has('last_name') ? ' has-error' : '' }}">
              <input type="text" class="form-control" placeholder="Last Name" name="last_name"  value="{{ old('last_name') }}" />
              @if ($errors->has('last_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('last_name') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group  {{ $errors->has('email') ? ' has-error' : '' }}">
              <input type="text" class="form-control" placeholder="Email" name="email"  value="{{ old('email') }}" />
              @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
               {{-- <select name="country_code" class="form-control country-code">
                  <option value="91">+91 (IND)</option>
                  @foreach($countries as $country)
                    <option value="{{$country->phonecode}}">+{{$country->phonecode}} ({{$country->iso3}})</option>
                  @endforeach
                </select>--}}
                </div>
                <input type="text" class="form-control" placeholder="Phone Number"id="phoneField1" name="phone_number" value="{{ old('phone_number') }}" >
                @if ($errors->has('phone_number'))
                <span class="help-block">
                    <strong>{{ $errors->first('phone_number') }}</strong>
                </span>
                @endif
              </div>
            </div>
										            
              <div class="form-group  {{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control" placeholder="Password"   name="password" />
                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @endif
            </div>
            <div class="form-group ">
                <input type="password" class="form-control" placeholder="Retype password"  name="password_confirmation" />
            </div>
            <div class="actions">
              <button type="submit" class="btn btn-primary">Signup</button>
            </div>
 {{--           <div class="or">
              <span>or Signup Using</span>
            </div>
            <div class="text-right">
              <button type="submit" class="btn btn-twitter">Twitter</button>
              <button type="submit" class="btn btn-facebook">Facebook</button>
              <button type="submit" class="btn btn-gplus">Gmail</button>
            </div> --}}
            <div class="m-0">
              <span class="additional-link">Already have an account? <a href="{{route('login')}}">Login</a></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

</div>
<!-- Container end -->

</body>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
<script src="{{asset('js/jquery.ccpicker.min.js')}}" type="text/javascript"></script>
<script>
			$( document ).ready(function() {
				$("#phoneField1").CcPicker({"countryCode":"us"});
			});
		</script>

@endsection