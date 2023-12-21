@extends('auth.layouts')

@section('content')
    <div class="container">
        @auth
            <h1 class="mt-5 mb-4">Profile</h1>
            <div class="row">
                <div class="justify-content-center">
                    <div class="mb-4 col-md-6">
                        <h2>Change Avatar</h2>
                        <form action="{{ route('profile.updateAvatar')}}" method="POST" class="php-email-form" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6 mb-4">
                                    <input type="file" name="avatar" id="avatar" accept="image/*" onchange="previewAvatar(event)" style="display:none">
                                    @if ($errors->has('avatar'))
                                        <span class="text-danger">{{ $errors->first('avatar') }}</span>
                                    @endif
                                    <label for="avatar" style="display: inline;"><img id="avatarPreview" src="{{asset('storage/'.$user->avatar)}}" alt="Choose Avatar" style="border-radius: 50%; max-width: 150px; max-height: 150px;"></label>
                                    
                                </div>                
                                <div class="col-md-6 mb-4" style="display: flex;  justify-content: center; align-items: center;">
                                    <button type="submit">Upload</button>
                                </div>               
                            </div>                        
                        </form>
                    </div>   
                    <div class="mb-4">
                        <h2>Update Profile</h2>
                        <form method="POST" action="{{ route('profile.update') }}" class="php-email-form" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="row"> 
                                <div class="form-group mb-4 col-md-6">
                                    <label for="name">User Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                                    @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-4 col-md-6">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                                    @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div> 
                                <div class="form-group mb-4">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title', $user->title) }}">
                                    @if ($errors->has('title'))
                                            <span class="text-danger">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-4">
                                    <label for="bio">Hobbies</label>
                                    <textarea class="form-control" name="bio" rows="5" placeholder="Message" required>{{ old('bio', $user->bio) }}</textarea>    
                                    @if ($errors->has('bio'))
                                            <span class="text-danger">{{ $errors->first('bio') }}</span>
                                    @endif                                
                                </div> 
                                
                            </div>   
                            <div class="row">
                                <div class="col-sm-6">                                    
                                    <div class="form-group">
                                        <label for="city" class="col-form-label text-md-end text-start">City</label>
                                        <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $user->city) }}">
                                        @if ($errors->has('city'))
                                            <span class="text-danger">{{ $errors->first('city') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="col-form-label text-md-end text-start">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                        @if ($errors->has('phone'))
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="website" class="col-form-label text-md-end text-start">Website</label>
                                        <input type="text" class="form-control" id="website" name="website" value="{{ old('website', $user->website) }}">
                                        @if ($errors->has('website'))
                                            <span class="text-danger">{{ $errors->first('website') }}</span>
                                        @endif
                                    </div>          
                                </div>
                                <div class="col-sm-6">                                             
                                    <div class="form-group">
                                        <label for="degree" class="col-form-label text-md-end text-start">Business Name</label>
                                        <input type="text" class="form-control" id="degree" name="degree" value="{{ old('degree', $user->degree) }}">
                                        @if ($errors->has('degree'))
                                            <span class="text-danger">{{ $errors->first('degree') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="col-form-label text-md-end text-start">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $user->title) }}">
                                        @if ($errors->has('title'))
                                            <span class="text-danger">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="birthday" class="col-form-label text-md-end text-start">Birthday</label>
                                        <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday', $user->birthday) }}">
                                        @if ($errors->has('birthday'))
                                            <span class="text-danger">{{ $errors->first('birthday') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>   
                            <div class="form-check">
                                <label class="col-form-label text-md-end text-start">Do you want to hide persnal information in about and contact page?</label><br>
                                <div style="align-items: center; display:flex">
                                    <input type="radio" style="width: 20px;" class="form-check-input"  id="hidden1" name="hidden" value="Yes" <?php echo $user->hidden =='Yes' ? 'checked' : ''; ?>>
                                    &nbsp;&nbsp;
                                    <label class="form-check-label" for="hidden1">Yes</label>
                                </div>
                                <div style="align-items: center; display:flex">
                                    <input type="radio" style="width: 20px;" class="form-check-input"  id="hidden2" name="hidden" value="No" <?php echo $user->hidden == 'No'? 'checked' : ''; ?>>
                                    &nbsp;&nbsp;
                                    <label class="form-check-label" for="hidden2">No</label><br>
                                </div>
                                @if ($errors->has('hidden'))
                                    <span class="text-danger">{{ $errors->first('hidden') }}</span>
                                @endif
                            </div>                
                            <button type="submit" class="mt-5 btn btn-primary">Save</button>
                        </form>                    
                    </div>
                    <div class="mb-4 col-md-6">
                        <h2>Change Password</h2>
                        <form method="POST" action="{{ route('profile.password') }}" class="php-email-form">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-4">
                                <label for="current_password">Current Password</label>
                                <input type="password" name="current_password" class="form-control">
                                @if ($errors->has('current_password'))
                                            <span class="text-danger">{{ $errors->first('current_password') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-4">
                                <label for="new_password">New Password</label>
                                <input type="password" name="new_password" class="form-control">
                                @if ($errors->has('new_password'))
                                            <span class="text-danger">{{ $errors->first('new_password') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-4">
                                <label for="new_password_confirmation">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control">
                                @if ($errors->has('new_password_confirmation'))
                                    <span class="text-danger">{{ $errors->first('new_password_confirmation') }}</span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </form>
                    </div>
                    </div>
                </div>
                @else
                    <p>You need to be logged in to access this page. Please <a href="{{ route('login') }}">log in</a>.</p>
                @endauth
            </div>

    <script>
        function previewAvatar(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var avatarPreview = document.getElementById('avatarPreview');
                avatarPreview.src = reader.result;
                avatarPreview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
    <script>
    // toast section for success or failure to upload image, to update the profile, and to change the password
    var message = "{{session('msg')}}";
    var success = "{{session('success')}}";
    console.log(success);
    if(success == "true"){
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
        toastr.success("{{ session('msg') }}");
    }
  </script>

@endsection

