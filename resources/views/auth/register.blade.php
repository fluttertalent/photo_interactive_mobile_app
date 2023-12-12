@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div style="margin-top: 100px;">        
        <form action="{{ route('store') }}" method="post" class="php-email-form">
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name" class="col-form-label text-md-end text-start">Name</label>                        
                            <input type="text" class="form-control " id="name" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label text-md-end text-start">Email Address</label>                     
                            <input type="email" class="form-control " id="email" name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif                        
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label text-md-end text-start">Password</label>                       
                            <input type="password" class="form-control " id="password" name="password">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif                        
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="col-form-label text-md-end text-start">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    <div class="form-group">
                        <label for="city" class="col-form-label text-md-end text-start">City</label>
                        <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}">
                        @if ($errors->has('city'))
                            <span class="text-danger">{{ $errors->first('city') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="phone" class="col-form-label text-md-end text-start">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                        @if ($errors->has('phone'))
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="website" class="col-form-label text-md-end text-start">Website</label>
                        <input type="text" class="form-control" id="website" name="website" value="{{ old('website') }}">
                        @if ($errors->has('website'))
                            <span class="text-danger">{{ $errors->first('website') }}</span>
                        @endif
                    </div>

                    

                    <div class="form-group">
                        <label for="degree" class="col-form-label text-md-end text-start">Degree</label>
                        <input type="text" class="form-control" id="degree" name="degree" value="{{ old('degree') }}">
                        @if ($errors->has('degree'))
                            <span class="text-danger">{{ $errors->first('degree') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="title" class="col-form-label text-md-end text-start">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                        @if ($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="birthday" class="col-form-label text-md-end text-start">Birthday</label>
                        <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday') }}">
                        @if ($errors->has('birthday'))
                            <span class="text-danger">{{ $errors->first('birthday') }}</span>
                        @endif
                    </div>
                    
                </div> 
                <div class="form-group">
                        <label for="bio" class="col-form-label text-md-end text-start">Bio</label>
                        <textarea class="form-control" id="bio" name="bio">{{ old('bio') }}</textarea>
                        @if ($errors->has('bio'))
                            <span class="text-danger">{{ $errors->first('bio') }}</span>
                        @endif
                </div>  
            </div>                                
            <div class="text-center"><button type="submit">Register</button></div>                
        </form>
        
    </div>
</div>
    
@endsection