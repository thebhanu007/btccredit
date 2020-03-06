@extends('layouts.app')

@section('content')
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Please Enter OTP We Have Sent To Your Email.</p>
      @if (session('message'))
                        <div class="alert alert-danger">
                            {{ session('message') }}
                        </div>
      @endif

      <form method="post" action="{{ url('verify-otp') }}">
      {{ csrf_field() }}
        <div class="input-group mb-3 {{ $errors->has('email') ? ' has-error' : '' }}">
          <input type="text" class="form-control" placeholder="OTP"  name="otp" value="{{ old('otp') }}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          @if ($errors->has('otp'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('otp') }}</strong>
                                    </span>
          @endif
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Verify OTP</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
</body>
@endsection
