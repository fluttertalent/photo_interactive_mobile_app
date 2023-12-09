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
@endsection
@section('scripts')
    @parent

    <!-- Sweet Alert 2 plugin -->
    <script src="{{ asset('backend/js/sweetalert2.js') }}"></script>
    <!--  Bootstrap Table Plugin    -->
    <script src="{{ asset('backend/js/bootstrap-table.js') }}"></script>
    <script type="text/javascript">

        var delete_button = function(id){
            swal({  
                title: "Are you sure?",
                text: "After you delete this picture, it will be never displayed again.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn btn-info btn-fill",
                confirmButtonText: "Yes, delete it!",
                cancelButtonClass: "btn btn-danger btn-fill",
                closeOnConfirm: false,
            },
            function(){
                $('form#delete-picture'+id).submit();
            });
        }

        var $table = $('#bootstrap-table');
        $().ready(function () {
            $table.bootstrapTable({
                toolbar: ".toolbar",
                clickToSelect: true,
                showRefresh: true,
                search: true,
                showToggle: true,
                showColumns: true,
                pagination: true,
                searchAlign: 'left',
                pageSize: 8,
                clickToSelect: false,
                pageList: [8, 10, 25, 50, 100],

                formatShowingRows: function (pageFrom, pageTo, totalRows) {
                    //do nothing here, we don't want to show the text "showing x of y from..."
                },
                formatRecordsPerPage: function (pageNumber) {
                    return pageNumber + " rows visible";
                },
                icons: {
                    refresh: 'fa fa-refresh',
                    toggle: 'fa fa-th-list',
                    columns: 'fa fa-columns',
                    detailOpen: 'fa fa-plus-circle',
                    detailClose: 'ti-close'
                }
            });

            //activate the tooltips after the data table is initialized
            $('[rel="tooltip"]').tooltip();

            $(window).resize(function () {
                $table.bootstrapTable('resetView');
            });
        });

    </script>
@endsection