@extends('admin.layouts')
@section('style')
    @parent
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="content">
                            <div class="toolbar">
                                <a href="{{url('admin/user/create')}}" rel="tooltip" title="Add New User"
                                   class="btn btn-danger" style="margin-right: 20px">
                                    <i class="ti-plus"></i>
                                </a>
                                <!--Here you can write extra buttons/actions for the toolbar-->
                            </div>
                            <table id="bootstrap-table" class="table">
                                <thead>
                                <th data-field="sn" class="text-center">S.N.</th>
                                <th data-field="id" class="text-center">User ID</th>
                                <th data-field="name" data-sortable="true">Name</th>
                                <th data-field="phone" data-sortable="true">Phone</th>
                                <th data-field="email" data-sortable="true">Email</th>                                
                                <th data-field="roles" data-sortable="true">Role</th>                           
                                <th data-field="actions" class="td-actions text-right">Actions
                                </th>
                                </thead>
                                <tbody>
                                @unless($users->count())
                                    @else
                                        @foreach($users as $index => $user)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ $user->email }}</td>                                               
                                                <td>
                                                    <button class="btn btn-default btn-xs btn-fill">{{ $user->role }}</button>
                                                </td>                                                
                                                <td>
                                                    <div class="table-icons">
                                                        <a rel="tooltip" title="Edit"
                                                           class="btn btn-simple btn-warning btn-icon table-action edit"
                                                           href="{{url('admin/user/'.$user->id.'/edit')}}">
                                                            <i class="ti-pencil-alt"></i>
                                                        </a>
                                                        <button rel="tooltip" title="Remove"
                                                                class="btn btn-simple btn-danger btn-icon table-action"
                                                                onclick="delete_button('{{$user->id}}')">
                                                            <i class="ti-close"></i>
                                                        </button>
                                                        <div class="collapse">
                                                            <form id="delete-user{{$user->id}}" action="/admin/user/{{ $user->id }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')                                                      
                                                                <button type="submit" class="btn btn-danger btn-ok">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endunless
                                </tbody>
                            </table>
                        </div>
                    </div><!--  end card  -->
                </div> <!-- end col-md-12 -->
            </div> <!-- end row -->
        </div>
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
                text: "After you delete the user, all user pictures will also be deleted.",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn btn-info btn-fill",
                confirmButtonText: "Yes, delete it!",
                cancelButtonClass: "btn btn-danger btn-fill",
                closeOnConfirm: false,
            },
            function(){
                $('form#delete-user'+id).submit();
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

