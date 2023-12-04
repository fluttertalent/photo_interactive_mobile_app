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
                                <div class="form-group">
                                    <label class="col-form-label text-md-end text-start" for="name" style="margin-right:10px">
                                        Item
                                    </label>
                                    <input class="form-control" type="text" name="item" value="">                                    
                                </div>                               
                                <input type="text" hidden name="user" value="{{$user->id}}">                                
                                </div>
                            </div>
                            <div class="text-center mb-4">
                                <label for="avatar" style="margin: auto;">Browse a Photo</label>
                                <div class="contentarea">                                    
                                    <div class="camera">
                                        <video id="video">Video stream not available.</video>
                                    </div>
                                    <div><label id="startbutton">or Take a photo</label></div>
                                    <canvas id="canvas"></canvas>
                                    <div class="output">
                                        <img id="photo" alt="The screen capture will appear in this box.">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center"><button type="submit">Upload</button></div>                         
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
  <script>
    (function() {

        var width = 320;
        var height = 0;

        var streaming = false;

        var video = null;
        var canvas = null;
        var photo = null;
        var startbutton = null;
        var downloadbutton = null;

        function startup() {
            video = document.getElementById('video');
            canvas = document.getElementById('canvas');
            photo = document.getElementById('photo');
            startbutton = document.getElementById('startbutton');
            downloadbutton = document.getElementById('downloadbutton');
            imginput = document.getElementById('');

            navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: false
                })
                .then(function(stream) {
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function(err) {
                    console.log("An error occurred: " + err);
                });

            video.addEventListener('canplay', function(ev) {
                if (!streaming) {
                    height = video.videoHeight / (video.videoWidth / width);

                    if (isNaN(height)) {
                        height = width / (4 / 3);
                    }

                    video.setAttribute('width', width);
                    video.setAttribute('height', height);
                    canvas.setAttribute('width', width);
                    canvas.setAttribute('height', height);
                    streaming = true;
                }
            }, false);

            startbutton.addEventListener('click', function(ev) {
                takepicture();
                ev.preventDefault();
            }, false); 

            clearphoto();
        }

        function clearphoto() {
            var context = canvas.getContext('2d');
            context.fillStyle = "#AAA";
            context.fillRect(0, 0, canvas.width, canvas.height);

            var data = canvas.toDataURL('image/png');
            photo.setAttribute('src', data);
        }

        function takepicture() {
            var context = canvas.getContext('2d');
            if (width && height) {
                canvas.width = width;
                canvas.height = height;
                context.drawImage(video, 0, 0, width, height);

                var data = canvas.toDataURL('image/png');
                // Create a new File object from the data URL
                const file = dataURLtoFile(data, 'image.jpg');

                // Create a new DataTransfer object and add the file to it
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);

                var input = document.getElementById('avatar');  
                photo.setAttribute('src', data);
                // Set the file as the value of the file input
                input.files = dataTransfer.files;
               
            } else {
                clearphoto();
            }
        }

        // Helper function to convert data URL to File object
        function dataURLtoFile(dataURL, filename) {
            const arr = dataURL.split(',');
            const mime = arr[0].match(/:(.*?);/)[1];
            const bstr = atob(arr[1]);
            let n = bstr.length;
            const u8arr = new Uint8Array(n);
            while (n--) {
                u8arr[n] = bstr.charCodeAt(n);
            }
            return new File([u8arr], filename, { type: mime });
        }
        window.addEventListener('load', startup, false);
    })();
    </script>
@endsection