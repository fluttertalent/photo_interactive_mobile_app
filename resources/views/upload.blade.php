@extends('auth.layouts')

@section('content')
    @auth
        <h1 class="mt-5 mb-4">Upload</h1>
        <div class="row">
            <div style="display: flex;  justify-content: center;  align-items: center;">
                <div class="mb-4 col-md-6">
                    <h2 class="text-center">Share your photos and let the world love them.</h2>
                    <form action="{{ route('upload.uploadPic') }}" method="POST" class="php-email-form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div style="display: flex;  justify-content: center;  align-items: center;" class="mt-4 mb-4">                                    
                                <input type="file" name="image" id="avatar" accept="image/*" onchange="previewAvatar(event)" style="display:none">                             
                                    <label class="col-form-label text-md-end text-center" for="name" style="margin-right:10px">
                                        Item
                                    </label>
                                    <input class="form-control" type="text" name="item" value="">                                   
                                <input type="text" hidden name="user" value="{{$user->id}}">                                
                                </div>
                            </div>
                            <div class="text-center mb-4">
                                <div class="photo-container" style="text-align:center">
                                    <img id="photo" src="{{asset('assets/img/emptyImg.jpeg')}}" alt="The screen capture will appear in this box.">
                                <label style="font-size:20px; color:black" for="avatar" class="photo-button"> <i class="bi bi-cloud-upload">&nbsp;&nbsp;</i>Press To Spy Now</label> 
                                </div>                              
                            </div>
                            <div class="text-center"><button type="submit">Submit</button></div>                         
                            <input class="form-control" type="text" id="lat" name="lat" value="" hidden>                                                                                    
                            <input class="form-control" type="text" id="lng" name="lng" value="" hidden>           
                    </form>
                </div> 
            </div>
        </div>
        @else
            <p>You need to be logged in to access this page. Please <a href="{{ route('login') }}">log in</a>.</p>
        @endauth
    <script>
        function previewAvatar(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var avatarPreview = document.getElementById('photo');
                avatarPreview.src = reader.result;
                avatarPreview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                $('#lat').val(latitude);
                $('#lng').val(longitude);
                
                console.log("Latitude: " + latitude);
                console.log("Longitude: " + longitude);
            });
            } else {
                console.log("Geolocation is not supported by this browser.");
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

    var errors = <?php echo json_encode($errors->all())?>;
    console.log(errors);
    if(Array.isArray(errors)){
        errors.forEach(function(item, index){
            toastr.error(item);
        });
    }
  </script> 
@endsection