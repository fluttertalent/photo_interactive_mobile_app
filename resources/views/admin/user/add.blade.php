@extends('admin.layouts')
@section('style')
    @parent
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Add User</h4>
                        </div>
                        <div class="content">
                        <form action="/admin/user/" method="POST" enctype="multipart/form-data" id="user-add-form">
                            <input type="hidden" name="_method" value="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control border-input"
                                               placeholder="ex: Leonardo" value="{{ old('name') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" name="phone" class="form-control border-input"
                                               placeholder="Phone Number" value="{{ old('phone') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">                               
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Avatar</label>
                                        <input type="file" name="avatar" class="form-control border-input">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control border-input"
                                               placeholder="ex: hari@gmail.com" value="{{ old('email') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control border-input"
                                               placeholder="new password for this user">
                                    </div>
                                </div>
                            </div>

                            @if(Auth::user()->role == "admin" && Auth::user()->id == 1)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select name="role" id="role" class="form-control">                                           
                                                <option value="user" @if (old('role') == 'user') selected="selected" @endif>User</option>
                                                <option value="admin" @if (old('role') == 'admin') selected="selected" @endif>Admin</option>                                             
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="text-center">
                                <button type="submit" class="btn btn-info btn-fill btn-wd">Create User</button>
                            </div>
                            <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent

    <!--  Forms Validations Plugin -->
    <script src="{{asset("backend/js/jquery.validate.min.js")}}"></script>

    <!--  Select Picker Plugin -->
    <script src="{{asset('backend/js/bootstrap-selectpicker.js')}}"></script>

    <!--  Plugin for Date Time Picker and Full Calendar Plugin-->
    <script src="{{asset("backend/js/moment.min.js")}}"></script>

    <!--  Date Time Picker Plugin is included in this js file -->
    <script src="{{asset('/backend/js/bootstrap-datetimepicker.js')}}"></script>
    <script>
        // Init DatetimePicker
        demo.initFormExtendedDatetimepickers();
    </script>

    <script>
        $().ready(function () {

            var $validator = $("#user-add-form").validate({
                rules: {
                    first_name: {
                        required: true,
                        minlength: 2,
                        maxlength: 25
                    },
                    last_name: {
                        required: true,
                        minlength: 2,
                        maxlength: 25
                    },
                    gender: {
                        required: true
                    },
                    email: {
                        required: true
                    },
                    address: {
                        maxlength: 200
                    },
                    about: {
                        maxlength: 300
                    }
                }
            });
        });

    </script>





@endsection

