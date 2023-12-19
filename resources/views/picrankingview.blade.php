@extends('auth.layouts')

@section('content')
    <div class="container">
        @auth  
        <div class="row">
            <div class="col-lg-12">                
                <div style="margin-top:8em" class="candidate-list">
                    <div style="text-align: center; ">
                        <p>BEST PICTURES</p>
                        <button id="week" class="review-button">WEEK</button>
                        <button id="month" class="review-button">MONTH</button>
                        <button id="year" class="review-button">YEAR</button>
                        <button id="total" class="review-button active">TOTAL</button>
                    </div>
                    <div id="pictureList"></div>                
                                        
                    </div>
            </div>
        </div>        
        @else
            <p class="text-white">You need to be logged in to access this page. Please <a href="{{ route('login') }}">log in</a>.</p>
        @endauth
    </div>    
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

    $(document).ready(function() {
        $(".review-button").click(function() {
            // Remove 'active' class from all buttons
            $(".review-button").removeClass("active");            
            // Add 'active' class to the clicked button
            $(this).addClass("active");
            $.get("/picranking?method="+ $(this).attr("id"), function(response) {
                // Handle the successful response from the server
                // Generate and display picture data
                var pictureList = $("#pictureList");
                pictureList.empty();

                $.each(response.pictures, function(index, picture) {
                    var pictureBox = $("<div></div>").addClass("candidate-list-box card mt-4").css("background", "#212529");
                    var pictureCardBody = $("<div></div>").addClass("p-4 card-body").appendTo(pictureBox);
                    var row = $("<div></div>").addClass("align-items-center row").appendTo(pictureCardBody);

                    var col1 = $("<div></div>").addClass("col-auto").appendTo(row);
                    var candidateListImages = $("<div></div>").addClass("candidate-list-images").appendTo(col1);
                    $("<a></a>").attr("href", "#").appendTo(candidateListImages);
                    $("<img>").attr("src", "storage/" + picture.url).css({"border-radius":"5%","height":"150px", "width":"150px"}).appendTo(candidateListImages);

                    var col2 = $("<div></div>").addClass("col-lg-5").appendTo(row);
                    var candidateListContent = $("<div></div>").addClass("candidate-list-content mt-3 mt-lg-0").appendTo(col2);
                    var h5 = $("<h5></h5>").addClass("fs-19 mb-0").appendTo(candidateListContent);
                    $("<span style='font-szie:20px'></span>").addClass("badge bg-success ms-1").appendTo(h5).html("<i class='mdi mdi-star align-middle'></i>" + picture.mark + "&nbsp&nbsp&nbsp" + picture.review_count + "reviews");
                                      
                    var wrapUl = $('<div></div>').addClass("col-lg-5");
                    var ul = $('<ul></ul>');
                    $('<li style="color:white; font-size:20px">'+picture.item+'</li>').appendTo(ul);
                    $('<li style="color:white; font-size:20px">'+picture.date+'</li>').appendTo(ul);
                    ul.appendTo(wrapUl);
                    wrapUl.appendTo(row);

                    var htmlString = $('<div style="margin-left:20px; margin-right:20px" class="mt-3 mb-3 row d-flex justify-content-center"> <div class="card shadow-0" id="card-'+picture.id+'" style="border-color: #212529; display:none;background-color: #212529;"> <div id="comments-'+picture.id+'" class="card-body p-4" style="border-color: #212529; background-color: #212529;"> </div> </div> </div>');
                    // Assuming 'targetElement' is the reference to the element where you want to add the HTML
                    $(htmlString).appendTo(row);
                    var favoriteIcon = $("<div></div>").addClass("favorite-icon").appendTo(pictureCardBody);
                    var anchorElement = $("<span id=viewcomment-"+picture.id+" style='float:right; color:white'></span>").html("View Comments").appendTo(favoriteIcon); 
                  
                    pictureBox.appendTo(pictureList); 
                });
            })
            .fail(function(xhr, status, error) {
                // Handle any errors that occur during the request
                console.log(error);
            });
        });

        $.get("/picranking?method=total", function(response) {
            // Handle the successful response from the server

            // Generate and display picture data
            var pictureList = $("#pictureList");
            pictureList.empty();

            $.each(response.pictures, function(index, picture) {

                var pictureBox = $("<div></div>").addClass("candidate-list-box card mt-4").css("background", "#212529");
                var pictureCardBody = $("<div></div>").addClass("p-4 card-body").appendTo(pictureBox);
                var row = $("<div></div>").addClass("align-items-center row").appendTo(pictureCardBody);

                var col1 = $("<div></div>").addClass("col-auto").appendTo(row);
                var candidateListImages = $("<div></div>").addClass("candidate-list-images").appendTo(col1);
                $("<a></a>").attr("href", "#").appendTo(candidateListImages);
                $("<img>").attr("src", "storage/" + picture.url).css({"border-radius":"5%", "height": "150px",
                    "width": "150px" }).appendTo(candidateListImages);

                var col2 = $("<div></div>").addClass("col-lg-5").appendTo(row);
                var candidateListContent = $("<div></div>").addClass("candidate-list-content mt-3 mt-lg-0").appendTo(col2);
                var h5 = $("<h5></h5>").addClass("fs-19 mb-0").appendTo(candidateListContent);
                $("<span style='font-szie:20px'></span>").addClass("badge bg-success ms-1").appendTo(h5).html("<i class='mdi mdi-star align-middle'></i>" + picture.mark + "&nbsp&nbsp&nbsp" + picture.review_count + "reviews");
                            
                var wrapUl = $('<div></div>').addClass("col-lg-5");
                var ul = $('<ul></ul>');
                $('<li style="color:white; font-size:20px">'+picture.item+'</li>').appendTo(ul);
                $('<li style="color:white; font-size:20px">'+picture.date+'</li>').appendTo(ul);
                ul.appendTo(wrapUl);
                wrapUl.appendTo(row);

                var htmlString = $('<div style="margin-left:20px; margin-right:20px" class="mt-3 mb-3 row d-flex justify-content-center"> <div class="card shadow-0" id="card-'+picture.id+'" style="border-color: #212529; display:none;background-color: #212529;"> <div id="comments-'+picture.id+'" class="card-body p-4" style="border-color: #212529; background-color: #212529;"> </div> </div> </div>');

                // Assuming 'targetElement' is the reference to the element where you want to add the HTML
                $(htmlString).appendTo(row);

                var favoriteIcon = $("<div></div>").addClass("favorite-icon").appendTo(pictureCardBody);
                $("<span id=viewcomment-"+picture.id+" style='float:right; color:white'></span>").html("View Comments").appendTo(favoriteIcon);
                
                pictureBox.appendTo(pictureList);
            });
        })
        .fail(function(xhr, status, error) {
            // Handle any errors that occur during the request
            console.log(error);
        });
    });


        $('body').on('click', "[id^='viewcomment-']", function(){        
            $('.card shadow-0 border').css("display", "none");
                var id =  $(this).attr('id').split('-')[1];
                console.log(id);            
                $.get(
                    "/comments?id="+id,        
                    function(response) {             
                        var swiperWrapper = $('#comments-'+id);
                        swiperWrapper.empty();

                        $.each(response.comments, function(index, comment) {
                            swiperWrapper.append(`
                                <div class="card mb-4" style="border-color: #214429; ">
                                    <div class="card-body" style="background-color: #212529;">          
                                        <div class="d-flex justify-content-between">
                                            <div class="d-flex flex-row align-items-center">
                                                <img src="{{asset('storage/')}}/${comment['avatar']}" alt="avatar" style="height:50px; width:50px" />
                                                <p style="color:white" class="small mb-0 ms-2">${comment['name']}</p>
                                                <div style="margin-left:20px;   ">
                                                    <p style="color:green">${comment['mark']}-Review</p>
                                                    <div>
                                                        <p style="color:white; font-size:20px" class="small mb-0 ms-2">${comment['comment']}</p>    
                                                    <div>       
                                                </div>                             
                                            </div>              
                                        </div>
                                    </div>
                                </div>
                            `);
                            $('#card-'+id).css("display","block");
                        });
                    }).fail(function(xhr, status, error) {
                        console.error(error);
                        alert("Failed to retrieve comment data.");
                });
    });
       


  </script>
@endsection

