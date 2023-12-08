@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5 ">
    <div class="col-sm-6" style="margin-top: 50px;">
    @csrf
        <table id="pictures-table" class="table table-dark  php-email-form">
            <thead class="thead-dark" style="height:50px">
                <tr>
                    <th>UserName</th>
                    <th>Date</th>
                    <th>Item</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <!-- @forelse ($pictures as $picture)
                    <tr id="{{$picture->id}}">
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
        <div class="col-sm-6"  id="map" style="height:550px; margin-top: 50px; padding:10px">

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

    <section id="testimonials" class="testimonials">
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
                    </div><!-- End testimonial item -->
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>
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
    // Note: This example requires that you consent to location sharing when
    // prompted by your browser. If you see the error "The Geolocation service
    // failed.", it means you probably did not give permission for the browser to
    // locate you.

    let map;

    function initMap() {
    
        var markerData = <?php echo json_encode($pictures); ?>;

        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 35.829290, lng: -75.823490 },
            zoom: 10,
        });

        

        for (let i = 0; i < markerData.length; i++) {   

            let icon = {
                url : "{{asset('storage/')}}"+ "/" + markerData[i].url + '#custom_marker',
                scaledSize : new google.maps.Size(50, 50),
            }

            var marker = new google.maps.Marker({
                position: { lat: parseFloat(markerData[i].lat), lng: parseFloat(markerData[i].lng)},
                map: map,
                icon: icon
            });     

            marker.addListener('click', function() {
                
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



        console.log("button");
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
                    console.log(pos);
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

                console.log(pos);
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
    console.log("Clicked on row:", id);

    $("#pictures-table tbody tr td").removeClass("selected");

    // Add the 'selected' class to the clicked tr element
    $(this).find("td").addClass("selected");

    var lat = $(this).attr("lat");
    var lng = $(this).attr("lng");
    console.log($(this).attr("lat"));
    console.log($(this).attr("lng"));

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
                zoom: 10,
            };
            
            console.log(pos);            
            map.setCenter(pos);

        },
        error: function(xhr, status, error) {
            console.error(error);
            alert("Failed to retrieve user data.");
        }
    });

    });
  // Code to be executed when a row in the pictures table is clicked
</script>
@endsection
