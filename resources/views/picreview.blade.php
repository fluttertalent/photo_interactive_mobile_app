@extends('auth.layouts')

@section('content')

<div class="container">
    <div class="row">
    <div class="col-sm-12">                         
        <div style="margin-top:8em" class="candidate-list">
        @foreach($pictures as $picture)
            <div class="candidate-list-box card mt-4" style=" background: #212529;">
                <div class="p-4 card-body">
                    <div class="align-items-center row">
                        <div class="col-auto">
                            <div class="candidate-list-images">
                                <a href="#">
                                    <img src="/storage/{{$picture->url}}" class="avatar-md img-thumbnail rounded-circle" style="height: 150px;">
                                </a>
                                <span class="badge bg-success ms-1"><i class='mdi mdi-star align-middle'></i>{{$picture->mark}}&nbsp&nbsp&nbsp{{$picture->review_count}} reviews</span>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="candidate-list-content mt-3 mt-lg-0">
                                <h5 class="fs-19 mb-0">
                                    <a href="#">{{$picture->item}}</a>
                                </h5>
                                <p class="text-white mb-2">{{$picture->date}}</p>                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="favorite-icon">
                    <span id="viewcomment-{{$picture->id}}" style="margin-right:10px;color:white; float:right">View Comments</span>
                </div>                        
            </div>
         
            <div style="margin-left:20px; margin-right:20px" class="mt-3 mb-3 row d-flex justify-content-center">
                <div class="card shadow-0" id="card-{{$picture->id}}" style="border-color: #212529; display:none;background-color: #212529;">
                    <div id="comments-{{$picture->id}}" class="card-body p-4" style="border-color: #212529; background-color: #212529;">
                        
                    </div>
            </div>
            </div>            
        @endforeach
        </div>
    </div>
    </div>
</div>
<script>
     $(document).ready(function() {
        
        $("[id^='viewcomment-']").click(function() {
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
});
</script>

@endsection