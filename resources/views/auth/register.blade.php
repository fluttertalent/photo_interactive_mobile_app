@extends('auth.layouts')
<style>

    input::placeholder {
      color: #ced4da !important;
      opacity: 1;
    }
    textarea::placeholder {
      color: #ced4da !important;
      opacity: 1;
    }

</style>
@section('content')

<div class="row justify-content-center mt-5">
    <div style="margin-top: 100px;">        
        <form action="{{ route('store') }}" method="post" id = "non-php-email-form" class="php-email-form">
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name" class="col-form-label text-md-end text-start">User Name</label>                        
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
                        <label for="degree" class="col-form-label text-md-end text-start">Business Name</label>
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
                        <label for="bio" class="col-form-label text-md-end text-start">Hobbies</label>
                        <textarea class="form-control" id="bio" name="bio">{{ old('bio') }}</textarea>
                        @if ($errors->has('bio'))
                            <span class="text-danger">{{ $errors->first('bio') }}</span>
                        @endif
                </div>
                <div style="margin-left:20px" class="form-check">
                    <label class="col-form-label text-md-end text-start">Do you want to hide persnal information in about and contact page?</label><br>                    
                    <div style="align-items: center; display:flex">
                        <input type="radio" style="width: 20px;" class="form-check-input"  id="hidden1" name="hidden" value="Yes" checked>
                        &nbsp;&nbsp;
                        <label class="form-check-label" for="hidden1">Yes</label>
                    </div>
                    <div style="align-items: center; display:flex">
                        <input type="radio" style="width: 20px;" class="form-check-input"  id="hidden2" name="hidden" value="No">
                        &nbsp;&nbsp;
                        <label class="form-check-label" for="hidden2">No</label><br>
                    </div>
                    @if ($errors->has('hidden'))
                        <span class="text-danger">{{ $errors->first('hidden') }}</span>
                    @endif
                </div>     
            </div>                                
            <div class="text-center"><button type="submit">Register</button></div>
            <div class="my-3">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
            </div>                
        </form>   
    <div class="page-header d-flex align-items-center">
        <div class="container position-relative">
            <div class="row d-flex justify-content-center">
            <div class="col-lg-6 text-center">
                <h2>Support Contact</h2>
            </div>
            </div>
        </div>
    </div>  
        <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">      
        <div class="row justify-content-center mt-4">
          <div class="col-lg-9">
            <form action="{{ route('contact.support')}}" method="post" role="form" class="php-email-form">
              @csrf
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
              </div>
              <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
              </div>              
              <div class="my-3">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>
          </div><!-- End Contact Form -->
        </div>
      </div>
    </section><!-- End Contact Section -->   
    </div>
</div>
<script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>
@endsection