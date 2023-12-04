@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div style="margin-top: 50px;">        
        <form action="{{ route('store') }}" method="post" class="php-email-form">
            @csrf
            <div class="row">
                <div class="form-group">
                    <label for="name" class="col-form-label text-md-end text-start">Name</label>                        
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    
                </div>
                <div class="form-group">
                    <label for="email" class="col-form-label text-md-end text-start">Email Address</label>                     
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif                        
                </div>
                <div class="form-group">
                    <label for="password" class="ol-form-label text-md-end text-start">Password</label>                       
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif                        
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="col-form-label text-md-end text-start">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div> 
            </div>                      
            <div class="text-center"><button type="submit">Register</button></div>                
        </form>
        
    </div>
</div>
    
@endsection