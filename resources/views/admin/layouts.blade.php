<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('backend/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('backend/img/favicon.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <title>{{ config('app.name', 'NatureSpy') }} - @yield('title', 'Dashboard')</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <meta name="viewport" content="width=device-width"/>

@section('styles')
    <!-- Bootstrap core CSS     -->
        <link href="{{asset('backend/css/bootstrap.min.css')}}" rel="stylesheet"/>

        <!--  Paper Dashboard core CSS    -->
        <link href="{{asset('backend/css/paper-dashboard.css')}}" rel="stylesheet"/>


        <!--  CSS for Demo Purpose, don't include it in your project     -->
        <link href="{{asset('backend/css/demo.css')}}" rel="stylesheet"/>
        <link href="{{asset('backend/css/style.css')}}" rel="stylesheet"/>


        <!--  Fonts and icons     -->
        <link href="{{asset('backend/css/font-awesome.min.css')}}" rel="stylesheet">
        <link href="{{asset('backend/css/font-muli.css')}}" rel='stylesheet' type='text/css'>
        <link href="{{asset('backend/css/themify-icons.css')}}" rel="stylesheet">
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @show
</head>

<body>
<div class="wrapper">
    @include('admin.components.side-navbar')

    <div class="main-panel">
        @include('admin.components.top-navbar')
        @yield('content')
        @include('admin.components.footer')
    </div>
</div>
</body>
@section('scripts')
    <!--   Core JS Files. Extra: PerfectScrollbar + TouchPunch libraries inside jquery-ui.min.js   -->
    <script src="{{asset('backend/js/jquery-1.10.2.js')}}" type="text/javascript"></script>
    <script src="{{asset('backend/js/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('backend/js/bootstrap.min.js')}}" type="text/javascript"></script>

    <!--  Notifications Plugin    -->
    <script src="{{asset('backend/js/bootstrap-notify.js')}}"></script>
    <!-- Sweet Alert 2 plugin -->
    <script src="{{asset("backend/js/sweetalert2.js")}}"></script>
    <!-- Paper Dashboard PRO Core javascript and methods for Demo purpose -->
    <script src="{{asset('backend/js/paper-dashboard.js')}}"></script>
    <!-- Paper Dashboard PRO Core javascript and methods for Demo purpose -->
    <script src="{{asset('backend/js/demo.js')}}"></script>


    <script type="text/javascript">
     
    // toast section for success or failure to upload image, to update the profile, and to change the password
        var message = "{{session('flash_message')}}";
        var success = "{{session('flash_title')}}";
   
        if(success == "true"){
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
            toastr.success("{{ session('msg') }}");
        }

        var errors = <?php echo json_encode($errors->all())?>;
  
        if(Array.isArray(errors)){
            errors.forEach(function(item, index){
                toastr.error(item);
            });
        }

    </script>


@show
</html>