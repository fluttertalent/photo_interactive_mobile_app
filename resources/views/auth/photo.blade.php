@extends('auth.layouts')

@section('content')
<div style="margin-top: 150px;">
<main id="main" data-aos="fade" data-aos-delay="1500" >
    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery">
        <div class="container-fluid">
            <div class="row gy-4 justify-content-center">
            @foreach($pictures as $picture)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="gallery-item h-100">
                <img src="{{asset('storage/')}}/{{$picture->url}}" class="img-fluid" alt="">
                <div class="gallery-links d-flex align-items-center justify-content-center">
                    <a href="{{asset('storage/')}}/{{$picture->url}}" title="{{$picture->date}}" class="glightbox preview-link"><i class="bi bi-arrows-angle-expand"></i></a>
                    <a href="/photos/{{$picture->id}}" class="details-link"><i class="bi bi-trash"></i></a>
                </div>
                </div>
            </div><!-- End Gallery Item -->
            @endforeach
            </div>
        </div>
    </section><!-- End Gallery Section -->

</main>
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

    var errors = <?php echo json_encode($errors->all())?>;
    console.log(errors);
    if(Array.isArray(errors)){
        errors.forEach(function(item, index){
            toastr.error(item);
        });
    }
    </script>
@endsection

