@extends('auth.layouts')

@section('content')
    <div class="container">
        @auth  
        <div class="row">
            <div class="col-lg-12">                
                <div style="margin-top:8em" class="candidate-list">
                <div style="text-align: center; ">
                    <button id="week" class="review-button">WEEK</button>
                    <button id="month" class="review-button">MONTH</button>
                    <button id="year" class="review-button">YEAR</button>
                    <button id="total" class="review-button active">TOTAL</button>
                </div>
                <div id="userList"></div>                
                                    
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
            $.get("/ranking?method="+ $(this).attr("id"), function(response) {
                // Handle the successful response from the server

                // Generate and display user data
                var userList = $("#userList");
                userList.empty();

                $.each(response.users, function(index, user) {
                    var userBox = $("<div></div>").addClass("candidate-list-box card mt-4").css("background", "#212529");
                    var userCardBody = $("<div></div>").addClass("p-4 card-body").appendTo(userBox);
                    var row = $("<div></div>").addClass("align-items-center row").appendTo(userCardBody);

                    var col1 = $("<div></div>").addClass("col-auto").appendTo(row);
                    var candidateListImages = $("<div></div>").addClass("candidate-list-images").appendTo(col1);
                    $("<a></a>").attr("href", "#").appendTo(candidateListImages);
                    $("<img>").attr("src", "storage/" + user.avatar).addClass("avatar-md img-thumbnail rounded-circle").css("height", "50px").appendTo(candidateListImages);

                    var col2 = $("<div></div>").addClass("col-lg-5").appendTo(row);
                    var candidateListContent = $("<div></div>").addClass("candidate-list-content mt-3 mt-lg-0").appendTo(col2);
                    var h5 = $("<h5></h5>").addClass("fs-19 mb-0").appendTo(candidateListContent);
                    $("<a></a>").attr("href", "/welcome/" + user.id).text(user.name).appendTo(h5);
                    $("<span></span>").addClass("badge bg-success ms-1").appendTo(h5).html("<i class='mdi mdi-star align-middle'></i>" + user.mark + "&nbsp&nbsp&nbsp" + user.review_count + "reviews");
                    $("<p></p>").addClass("text-white mb-2").text(user.title).appendTo(candidateListContent);

                    var ul = $("<ul></ul>").addClass("list-inline mb-0 text-muted").appendTo(candidateListContent);
                    $("<li></li>").addClass("text-light list-inline-item").html("<i class='mdi mdi-map-marker'></i>" + (user.city || "Unknown")).appendTo(ul);

                    var favoriteIcon = $("<div></div>").addClass("favorite-icon").appendTo(userCardBody);
                    $("<a></a>").attr("href", "#").html("<i class='mdi mdi-thumb-up-outline'></i>").appendTo(favoriteIcon);

                    userBox.appendTo(userList);
                });
            })
            .fail(function(xhr, status, error) {
                // Handle any errors that occur during the request
                console.log(error);
            });
        });

        $.get("/ranking?method=total", function(response) {
            // Handle the successful response from the server

            // Generate and display user data
            var userList = $("#userList");

            $.each(response.users, function(index, user) {
                var userBox = $("<div></div>").addClass("candidate-list-box card mt-4").css("background", "#212529");
                var userCardBody = $("<div></div>").addClass("p-4 card-body").appendTo(userBox);
                var row = $("<div></div>").addClass("align-items-center row").appendTo(userCardBody);

                var col1 = $("<div></div>").addClass("col-auto").appendTo(row);
                var candidateListImages = $("<div></div>").addClass("candidate-list-images").appendTo(col1);
                $("<a></a>").attr("href", "#").appendTo(candidateListImages);
                $("<img>").attr("src", "storage/" + user.avatar).addClass("avatar-md img-thumbnail rounded-circle").css("height", "50px").appendTo(candidateListImages);

                var col2 = $("<div></div>").addClass("col-lg-5").appendTo(row);
                var candidateListContent = $("<div></div>").addClass("candidate-list-content mt-3 mt-lg-0").appendTo(col2);
                var h5 = $("<h5></h5>").addClass("fs-19 mb-0").appendTo(candidateListContent);
                $("<a></a>").attr("href", "/welcome/" + user.id).text(user.name).appendTo(h5);
                $("<span></span>").addClass("badge bg-success ms-1").appendTo(h5).html("<i class='mdi mdi-star align-middle'></i>" + user.mark + "&nbsp&nbsp&nbsp" + user.review_count + "reviews");
                $("<p></p>").addClass("text-white mb-2").text(user.title).appendTo(candidateListContent);

                var ul = $("<ul></ul>").addClass("list-inline mb-0 text-muted").appendTo(candidateListContent);
                $("<li></li>").addClass("text-light list-inline-item").html("<i class='mdi mdi-map-marker'></i>" + (user.city || "Unknown")).appendTo(ul);

                var favoriteIcon = $("<div></div>").addClass("favorite-icon").appendTo(userCardBody);
                $("<a></a>").attr("href", "#").html("<i class='mdi mdi-thumb-up-outline'></i>").appendTo(favoriteIcon);
                userBox.appendTo(userList);
            });
        })
        .fail(function(xhr, status, error) {
            // Handle any errors that occur during the request
            console.log(error);
        });
    });
  </script>
@endsection

