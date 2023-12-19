@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5 ">
    @csrf    
    <div class="col-sm-6" style="margin-top: 50px;">
    <table id="pictures-table" class="table table-dark  php-email-form">
            <thead class="thead-dark">
                <tr>
                    <th>UserName</th>
                    <th>Date</th>
                    <th>Item</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <!-- @forelse ($pictures as $picture)
                    <tr id="{{$picture->id}}" lat="{{$picture->lat}}" lng="{{$picture->lng}}">
                        <td>{{ $picture->userName }}</td>
                        <td>{{ $picture->date }}</td>
                        <td>{{ $picture->item }}</td>
                        <td>{{ $picture->time }}</td>
                    </tr>
                @empty
                    @for ($i = 0; $i < 10; $i++)
                    <tr>
                        <td style="height: 50px"></td>
                        <td style="height: 50px"></td>
                        <td style="height: 50px"></td>
                        <td style="height: 50px"></td>
                    </tr>
                    @endfor
                @endforelse -->
            </tbody>
        </table>
    </div>
    <div class="col-sm-6" id="map" style="height:550px; margin-top: 50px; padding:10px">
    </div>       
    
    <!--Modal: modalRelatedContent-->
    <div class="modal fade right" id="modalRelatedContent" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false" pictureId="">
        <!--Content-->
        <div  class="modal-dialog modal-side modal-bottom-right modal-notify modal-info" role="document">
            <div class="modal-content">
                <!--Header-->
                <div  style="background:grey" class="modal-header">
                    <p id="photoItem" style="color:black; font-size: 20px;" class="heading">Photos</p>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                </div>
                <!--Body-->
                <div style="background:grey" class="modal-body">
                    <div class="row">
                        <div class="col-5">
                            <img id="imgSource" style="border-radius:5%" src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(55).webp"
                                class="img-fluid" alt="">
                            <p id="imgDate"></p>
                        </div>
                        <div class="col-7">
                        <p class="text-center">
                            <strong id="photoItem">Rate the post</strong>
                        </p>
                        <div class="container">                    
                            <input id="rate" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="1">
                        </div>
                        <p class="text-center">
                            <strong id="photoItem">Comment</strong>
                        </p>
                        <div class="container">                    
                            <textarea class="form-control" id="comment" name="comment">{{ old('comment') }}</textarea>
                            @if ($errors->has('comment'))
                                <span class="text-danger">{{ $errors->first('comment') }}</span>
                            @endif
                        </div>
                        </div>  
                    </div>
                </div>
                <div style="background:grey" class="modal-footer justify-content-center">
                <a type="button" id="sendReview" style="background: var(--color-primary);  border: 0; padding: 10px 35px;  color: #fff; transition: 0.4s; border-radius: 4px;" class=" waves-effect waves-light">Send
                    <i class="fas fa-paper-plane ml-1"></i>
                </a>
                <a type="button" style="background: var(--color-primary);  border: 0; padding: 10px 35px;  color: #fff; transition: 0.4s; border-radius: 4px;" class="close" data-dismiss="modal">Cancel</a>
                </div>
            </div>
        <!--/.Content-->
        </div>
    </div>
    <!--Modal: modalRelatedContent-->


    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div style="background:grey" class="modal-header">
                    <h5 class="modal-title" style="color:black; font-size: 20px;" id="imageModalLabel">Images</h5>
                    <button type="button" class="images-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background:grey; display: flex;    flex-wrap: wrap;    justify-content: center;    align-items: center;" id="imageModalBody">
                    <!-- Images will be added dynamically here -->
                </div>
                <div style="background:grey" class="modal-footer">
                    <button type="button" class="btn btn-secondary images-close"  data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <section id="about" class="about mt-5">
        <a href="#" id="userLink">
            <div class="container">
                <div class="row gy-4 justify-content-center">
                    <div class="col-lg-3">
                        <div style="border: 1px solid white;  display: inline-block; padding: 5px; width: 300px; max-width:100%;">
                            <img id="avatarPreview" style="width:100%; height:100%; " src="/storage/avatars/empty.jpeg" class="img-fluid   float-end w-100" alt="">
                        </div>
                    </div>
                    <div class="col-lg-9 content">                
                        <h2 id="userTitle">User Profile Title</h2>
                        <div class="row">
                            <div class="col-lg-6"></div>   
                            <div class="col-lg-6"></div>                         
                            <div class="col-lg-6">
                                <ul>
                                    <li><i class="bi bi-chevron-right"></i><strong>Name:</strong><span id ="userName">Name</span></li>                  
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul>
                                    <li><i class="bi bi-chevron-right"></i><strong>Email Address:</strong><span id = "userEmail">Email Address</span></li>                  
                                </ul>
                            </div>
                        </div>
                        <p id="userBio" class="py-3">
                            User Profile Bio Description
                        </p>            
                    </div>         
                </div>
            </div>
        </a>   
    </section>

    <!-- <section id="testimonials" class="testimonials">
        <div class="container">
            <div class="section-header">
            <h2>Uploaded Images</h2>
            </div>
            <div class="slides-3 swiper">
                <div class="swiper-wrapper">                    
                    <div class="swiper-slide">
                    <div class="testimonial-item">
                        <img src="">
                    </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section> -->
    <!-- End Testimonials Section -->

        <!-- @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @else
            <div class="alert alert-success">
                You are logged in!
            </div>       
        @endif   -->
</div>
<script>
    
    let map;
    var markerData = <?php echo json_encode($pictures); ?>;

    function initMap() {
    
        

        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 35.829290, lng: -75.823490 },
            zoom: 10,            
        });        

        // Add an event listener for the zoom_changed event
        map.addListener('zoom_changed', function() {
        const zoomLevel = map.getZoom();
  
        });

        var markers = [];

        for (let i = 0; i < markerData.length; i++) {   

            let icon = {
                url : "{{asset('storage/')}}"+ "/" + markerData[i].url + '#custom_marker',
                rUrl: "{{asset('storage/')}}"+ "/" + markerData[i].url,
                scaledSize : new google.maps.Size(50, 50),
            }

            var marker = new google.maps.Marker({
                position: { lat: parseFloat(markerData[i].lat), lng: parseFloat(markerData[i].lng)},
                map: map,
                icon: icon,
                id:markerData[i].id
            });     

            markers.push(marker);          
            
            marker.addListener('click', function() {

                $('#photoItem').html(markerData[i].item);
                $('#imgSource').attr('src',  "{{asset('storage/')}}"+ "/" + markerData[i].url);
                $("#modalRelatedContent").modal("show");
                $("#modalRelatedContent").attr('pictureId', markerData[i].id);
                $('#imgDate').html(markerData[i].date);
                // Handle marker click event here
                $.ajax({
                    url: "/pictures/" + markerData[i].id,
                    type: "GET",
                    success: function(data) {
                        let imageUrl = "{{asset('storage/')}}"+ "/" + data['user'].avatar;
                        let name = data['user'].name;
                        let email = data['user'].email;
                        let title = data['user'].title;
                        let bio =  data['user'].bio;

                        // Set the values of the input fields and image preview
                        $("#avatarPreview").attr("src", imageUrl);
                        $("#userName").text(name);
                        $("#userEmail").text(email);
                        $("#userTitle").text(title);
                        $('#userBio').text(bio);
                        $('#userLink').attr('href', '/welcome/' + data['user'].id);
                        var swiperWrapper = $('.swiper-wrapper');
                        swiperWrapper.empty();

                        $.each(data['pictures'], function(index, picture) {
                            var swiperSlide = $('<div>').addClass('swiper-slide');
                            var testimonialItem = $('<div>').addClass('testimonial-item');
                            var image = $('<img>').attr('src', "{{asset('storage/')}}"+ "/" +picture.url);
                            testimonialItem.append(image);
                            swiperSlide.append(testimonialItem);
                            swiperWrapper.append(swiperSlide);
                        });

                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert("Failed to retrieve user data.");
                    }
                });
                // You can perform any desired actions when the marker is clicked
            });

        }      

            // Create a new MarkerClusterer instance
            var markerCluster = new MarkerClusterer(map, markers, {
                imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
            });            

            function showDialogWithImages(markers) {

                // Assuming you are using a simple Bootstrap modal for displaying the images
                var modalBody = document.getElementById('imageModalBody');

                // Clear existing images
                modalBody.innerHTML = '';

                // Add images to the modal
                markers.forEach(function(marker){

                    var img = document.createElement('img');
                    img.src = marker.getIcon().rUrl;                    
                    img.id = "img- "+marker['id'];
                    img.style = "max-width: 300px ;height: auto; border-radius:5%; margin-top:10px"
                    var div = document.createElement('div');
                    div.classList.add("image-container");                    
                    div.appendChild(img);
                    modalBody.appendChild(div);

                });

                // Show the modal
                $('#imageModal').modal('show');
            }

            google.maps.event.addListener(markerCluster, 'clusterclick', function(cluster) {
                // your code here
                console.log(map.getZoom());
                if (map.getZoom() === 22) {
                    var markers = cluster.getMarkers();
                    // Assuming you have a function to retrieve image URLs from markers
                    // Assuming you have a function to display a dialog with images
                    showDialogWithImages(markers);
                }
            });
            

        // Set the minimum cluster size to 2     
    
        const locationButton = document.createElement("button");
        locationButton.textContent = "Pan to Current Location";
        locationButton.classList.add("custom-map-control-button");
        map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(locationButton);  
            
        

        //add the event to the centering button
        locationButton.addEventListener("click", () => {
            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                        zoom: 10,
                    };
                   
                    toastr.success("The current user's location is "+ pos.lat +"," + pos.lng);
                    map.setCenter(pos);
                    },
                    () => {
                        handleLocationError(true,  map.getCenter());
                    },
                );
            } else {
            console.log("Browser doesn't support Geolocation");
            // Browser doesn't support Geolocation
            handleLocationError(false,  map.getCenter());
            }
        });


        // Try HTML5 geolocation.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
            (position) => {

                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                    zoom: 10,
                };


                toastr.success("The current user's location is "+ pos.lat +"," + pos.lng);
                map.setCenter(pos);

                $.ajax({
                    url: "/pictures/table",
                    type: "POST",
                    data: {
                        "lat":pos.lat,
                        "lng":pos.lng,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                    },
                    success: function(data) {    

                        var pictureTable = $('#pictures-table tbody');                         
                        $.each(data['pictures'], function(index, picture) {
                            pictureTable.append(
                                "<tr id=" + picture.id + " lat="+ picture.lat+ " lng="+ picture.lng + ">" +
                                    "<td>" + picture.userName + "</td>" +
                                    "<td>" + picture.date + "</td>" +
                                    "<td>" + picture.item + "</td>" +
                                    "<td>" + picture.time + "</td>" +
                                "</tr>"
                            );
                        });

                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert("Failed to retrieve picture data.");
                    }
                });
            },
            () => {
            handleLocationError(true,  map.getCenter());
            },
        );
        } else {
            console.log("Browser doesn't support Geolocation");
            //Browser doesn't support Geolocation
            handleLocationError(false, map.getCenter());
        }        
    }

    function handleLocationError(browserHasGeolocation,  pos) {
        toastr.error(
            browserHasGeolocation
            ? "Error: The Geolocation service failed."
            : "Error: Your browser doesn't support geolocation.",
        );
    }

    window.initMap = initMap;   

    // Get all the tr elements in the table  
    $('body').on('click', '#pictures-table tbody tr', function() {
        // Get the id of the clicked tr element
    let id = $(this).attr("id");
    $("#pictures-table tbody tr td").removeClass("selected");
    // Add the 'selected' class to the clicked tr element
    $(this).find("td").addClass("selected");
    var lat = $(this).attr("lat");
    var lng = $(this).attr("lng");


    $.ajax({
        url: "/pictures/" + id,
        type: "GET",
        success: function(data) {    

            let imageUrl = "{{asset('storage/')}}"+ "/" + data['user'].avatar;
            let name = data['user'].name;
            let email = data['user'].email;
            let title = data['user'].title;
            let bio =  data['user'].bio;

            // Set the values of the input fields and image preview
            $("#avatarPreview").attr("src", imageUrl);
            $("#userName").text(name);
            $("#userEmail").text(email);
            $("#userTitle").text(title);
            $('#userBio').text(bio);
            $('#userLink').attr('href', '/welcome/' + data['user'].id);

            var swiperWrapper = $('.swiper-wrapper');
            swiperWrapper.empty();

            $.each(data['pictures'], function(index, picture) {
                var swiperSlide = $('<div>').addClass('swiper-slide');
                var testimonialItem = $('<div>').addClass('testimonial-item');
                var image = $('<img>').attr('src', "{{asset('storage/')}}"+ "/" +picture.url);
                testimonialItem.append(image);
                swiperSlide.append(testimonialItem);
                swiperWrapper.append(swiperSlide);
            });

            const pos = {
                lat: parseFloat(lat),
                lng: parseFloat(lng),
                zoom: 22,
            };            
             
            const newZoom = 22;

            // Update the map options with the new center and zoom level
            map.setOptions({
            center: pos,
            zoom: newZoom
            });

        },
        error: function(xhr, status, error) {   
            console.error(error);
            alert("Failed to retrieve user data.");
        }
    });
    });
    $(document).ready(function() {
        // Note: This example requires that you consent to location sharing when
        // prompted by your browser. If you see the error "The Geolocation service
        // failed.", it means you probably did not give permission for the browser to
        // locate you.
        $('.close').click(function() {           
            $("#modalRelatedContent").modal('hide');
        });

        
        $('.images-close').click(function() {           
            $("#imageModal").modal('hide');
        });

       $('body').on('click','[id^="img-"]',
            function() {
                // Your click event handling code here
                var id =  $(this).attr('id').split('-')[1];
                console.log(id);
                var marker = {};
                for(var i =0;i<markerData.length;i++){
                    if(markerData[i].id == id)
                    {
                        marker = markerData[i];
                        break;
                    }
                }
                console.log(marker);
                $('#photoItem').html(marker.item);
                $('#imgSource').attr('src',  "{{asset('storage/')}}"+ "/" + marker.url);
                $('#imageModal').modal("hide");
                $("#modalRelatedContent").modal("show");
                $("#modalRelatedContent").attr('pictureId', marker.id);
                $('#imgDate').html(marker.date);
                // Handle marker click event here
                $.ajax({
                    url: "/pictures/" + marker.id,
                    type: "GET",
                    success: function(data) {
                        
                        let imageUrl = "{{asset('storage/')}}"+ "/" + data['user'].avatar;
                        let name = data['user'].name;
                        let email = data['user'].email;
                        let title = data['user'].title;
                        let bio =  data['user'].bio;

                        // Set the values of the input fields and image preview
                        $("#avatarPreview").attr("src", imageUrl);
                        $("#userName").text(name);
                        $("#userEmail").text(email);
                        $("#userTitle").text(title);
                        $('#userBio').text(bio);
                        $('#userLink').attr('href', '/welcome/' + data['user'].id);
                        var swiperWrapper = $('.swiper-wrapper');
                        swiperWrapper.empty();

                        $.each(data['pictures'], function(index, picture) {
                            var swiperSlide = $('<div>').addClass('swiper-slide');
                            var testimonialItem = $('<div>').addClass('testimonial-item');
                            var image = $('<img>').attr('src', "{{asset('storage/')}}"+ "/" +picture.url);
                            testimonialItem.append(image);
                            swiperSlide.append(testimonialItem);
                            swiperWrapper.append(swiperSlide);
                        });

                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert("Failed to retrieve user data.");
                    }
                });
        });


        $('#sendReview').click(function(){    

            const mark = $('#rate').val();
            var picture_id = $('#modalRelatedContent').attr('pictureId');
            var comment = $('#comment').val();

            $.ajax({
                url: "/reviews",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
                },
                data: {
                    "mark": mark,
                    "picture_id": picture_id,
                    "comment" : comment
                }
                ,
                success: function(data) { 
                    if(data['data'] == 'success'){
                        toastr.success("Review of the post has been sent successfully!");
                        $("#modalRelatedContent").modal('hide');
                    }else if(data['data'] == 'unauthorized'){
                        toastr.error("You should login before reviewing the post.");
                        $("#modalRelatedContent").modal('hide');
                    }
                },
                
                error: function(xhr, status, error){
                    console.log(error);
                    toastr.error("Failed to save review data.");
                }
            });

            // Code to be executed when a row in the pictures table is clicked
        });
});    
  </script>
@endsection
