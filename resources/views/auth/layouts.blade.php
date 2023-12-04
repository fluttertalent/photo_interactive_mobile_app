<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 10 Custom User Registration & Login Tutorial - AllPHPTricks.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
    <!-- Vendor CSS Files -->
    <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/aos/aos.css')}}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{asset('assets/css/main.css')}}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <style>
        .selected {
            background-color: green !important;
        }
    </style>
    <style>
    #video {
        border: 2px solid black;
        width: 320px;
        height: 240px;
    }
    #photo {
        border: 2px solid black;
        width: 320px;
        height: 240px;
    }
    #canvas {
        display: none;
    }
    .camera {
        width: 340px;
        display: inline-block;
    }
    .output {
        width: 340px;
        padding-top: 20px;
        display: inline-block;
    }
    
    #downloadbutton {
        display: block;
        position: relative;
        margin-left: auto;
        margin-right: auto;
        bottom: -10px;
        padding: 18px;
        background-color: #4caf50;
        border: 1px solid rgba(0, 0, 0, 0.7);
        font-size: 14px;
        color: rgba(255, 255, 255, 1.0);
        cursor: pointer;
    }
    .contentarea {
        font-size: 16px;
        font-family: Arial;
        text-align: center;
    }
    .custom-map-control-button {
       background-color: #fff;
       border: 0;
       margin-bottom: 10px;
       padding:10px;
       font-size: 15px;
       cursor: pointer;
    }

    #map {
        position: relative;
    }

    #pan-button {
        position: absolute;
        top: 10px; /* Adjust the top position as needed */
        left: 20px; /* Adjust the right position as needed */
        z-index: 1; /* Ensure the button appears above other elements */
    }
    </style>
</head>
<body>
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <a href="{{url('/upload')}}" class="logo d-flex align-items-center  me-auto me-lg-0">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <i class="bi bi-camera"></i>
                <h1>Take a Photo</h1>
            </a>
            <nav id="navbar" class="navbar">
                <ul>
                
                    <li><a href="{{url('/')}}">Dashboard</a></li>                
                
                    <li><a href="{{url('/upload')}}">Upload</a></li>
                   
                    @guest
                    <li>
                        <a class="{{ (request()->is('login')) ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                    </li>
                    <li>
                        <a class="{{ (request()->is('register')) ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
                    </li>
                    </ul>
            </nav>
            <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
            <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
                    @else
                        <li class="dropdown"><a href="#"><span> {{ Auth::user()->name }}</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                            <ul>
                                <li>
                                    <a  href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"
                                        >Logout</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                        </form>
                                </li>
                                <li><a href="{{ route('profile.show') }}"                            
                                    >Profile</a>                           
                                </li>            
                            </ul>
                        </li>               
                </ul>
            </nav>
            <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
            <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>                
            @endguest                         
    </header><!-- End Header -->
    <section id="contact" class="contact">
        <div class="container">
            @yield('content')
        </div>
    </section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>    
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2zf2X2V4s5jEuzb9wzCCdCDdnjW5q8E4&callback=initMap&v=weekly"
    defer
>
</script>
<script>

</script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<!-- Vendor JS Files -->
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
<script src="{{asset('assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
<script src="{{asset('assets/vendor/aos/aos.js')}}"></script>


<!-- Template Main JS File -->
<script src="{{asset('assets/js/main.js')}}"></script>
<script>
    
</script>
</body>
</html>