@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8" style="margin-top: 100px;">
        <div class="row justify-content-center mt-4">
          <div class="col-lg-9 justify-content-center text-center" >
            <div class="col-auto" >
              <img style="max-width: 100%;" src="{{asset('assets/img/login.jpg')}}">
            </div>
            <form action="{{ route('authenticate') }}" method="post" role="form" class="php-email-form">
            @csrf
              <div class="row">
                <div class="form-group">
                    <label for="email" class=" col-form-label text-md-end text-start">Email Address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                          <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                </div>
                <div class="form-group mt-3 mt-md-0">
                      <label for="password" class=" col-form-label text-md-end text-start">Password</label>                       
                      <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                </div>
              </div>
              <span style="color:blue"><a class="" href="{{ route('password.request') }}">Forgot Password?</a></span></p>             
              <div class="text-center"><button type="submit">Log In</button></div>
              <p>Don't have an account? <span style="color:blue"><a class="" href="{{ route('register') }}">Register</a></span></p>
            </form>
          </div><!-- End Contact Form -->
    </div>    
</div>
    
@endsection