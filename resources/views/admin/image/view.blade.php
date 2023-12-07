@extends('admin.layouts')
@section('style')
    @parent
@endsection
@section('content')
<!-- Carousel wrapper -->
<div
  id="carouselMultiItemExample"
  class="carousel slide carousel-dark text-center"
  data-mdb-ride="carousel"
>
  <!-- Controls -->
  <!-- <div class="d-flex justify-content-center mb-4">
    <button
      class="carousel-control-prev position-relative"
      type="button"
      data-mdb-target="#carouselMultiItemExample"
      data-mdb-slide="prev"
    >
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button
      class="carousel-control-next position-relative"
      type="button"
      data-mdb-target="#carouselMultiItemExample"
      data-mdb-slide="next"
    >
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div> -->
  <!-- Inner -->
 
  <div class="carousel-inner py-4">
  
    <!-- Single item -->
    <div class="carousel-item">
      <div class="container">
        <div class="row">
            @foreach($pictures as $picture)
            <div class="col-lg-4 d-none d-lg-block">
                <div class="card">
                    <img
                        src="{{asset('storage/'.$picture->url)}}"
                        class="card-img-top"
                        alt="{{$picture->item}}"
                    />
                    <div class="card-body">
                        <h5 class="card-title">{{$picture->item}}</h5>
                        <p class="card-text">                           
                        </p>
                        <button rel="tooltip" title="Remove"
                                class="btn btn-simple btn-danger btn-icon table-action"
                                onclick="delete_button('{{$picture->id}}')">
                            Delete
                        </button>
                        <div class="collapse">
                            <form id="delete-picture{{$picture->id}}" action="/admin/image/{{ $picture->id }}" method="POST">
                                @csrf
                                @method('DELETE')                                                      
                                <button type="submit" class="btn btn-danger btn-ok">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        </div>
      </div>
  </div>
  <!-- Inner -->
</div>

<!-- Carousel wrapper -->
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