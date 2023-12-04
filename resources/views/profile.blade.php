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
                                    <label for="name">Name</label>
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
                                    <label for="bio">Bio Descritption</label>
                                    <textarea class="form-control" name="bio" rows="5" placeholder="Message" required>{{ old('bio', $user->bio) }}</textarea>    
                                    @if ($errors->has('bio'))
                                            <span class="text-danger">{{ $errors->first('bio') }}</span>
                                    @endif                                
                                </div> 
                            </div>                      
                            <button type="submit" class="btn btn-primary">Save</button>
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

