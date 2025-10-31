<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
    <link rel="icon" href="{{ asset('images/icon1.png') }}" type="image/png" sizes="16x16">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <title>{{ $title ?? 'Rapha Hotel' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Welcome to Rapha Hotel, a luxurious hotel in the heart of the city. We offer a wide range of rooms and suites, as well as a variety of amenities to make your stay as comfortable as possible.' }}">
    <meta content="" name="keywords" >
    <meta content="" name="author" >
    <!-- CSS Files
    ================================================== -->
      @vite(['resources/css/app.css'])
      
    <link href="{{ asset('css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('css/swiper.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('css/coloring.css') }}" rel="stylesheet" type="text/css" >
    <!-- color scheme -->
    <link id="colors" href="{{ asset('css/colors/scheme-01.css')}}" rel="stylesheet" type="text/css" >

</head>
<body>
      <div id="wrapper">
        <a href="homepage-city-apartment.html#" id="back-to-top"></a>
        
        <!-- page preloader begin -->
        <div id="de-loader"></div>
        <!-- page preloader close -->

        <!-- header begin -->
        <header class="transparent has-topbar">
            <div id="topbar">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-between xs-hide">
                                <div class="header-widget d-flex">                                    
                                    <div class="topbar-widget"><a href="#"><i class="icofont-location-pin"></i>No. 1 Rapha Avenue
                                        Secretariat Road, Umuahia
                                        Abia State, Nigeria.</a></div>
                                    <div class="topbar-widget"><a href="#"><i class="icofont-phone"></i>0916 443 9220, 0904 621 0001</a></div>
                                    <div class="topbar-widget"><a href="#"><i class="icofont-envelope"></i>raphahotelltd25@gmail.com </a></div>
                                </div>

                                <div class="social-icons">
                                    <a href="#"><i class="fa-brands fa-facebook fa-lg"></i></a>
                                    <a href="#"><i class="fa-brands fa-x-twitter fa-lg"></i></a>
                                    <a href="#"><i class="fa-brands fa-youtube fa-lg"></i></a>
                                    <a href="#"><i class="fa-brands fa-pinterest fa-lg"></i></a>
                                    <a href="#"><i class="fa-brands fa-instagram fa-lg"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="de-flex sm-pt10">
                            <div class="de-flex-col">
                                <!-- logo begin -->
                                <div id="logo">
                                    <a href="{{ route('rapha.home') }}">
                                        <img class="logo-main" src="{{asset('images/logo-white1.webp')}}" alt="logo" >
                                        <img class="logo-scroll" src="{{asset('images/logo-black1.webp')}}" alt="" >
                                        <img class="logo-mobile" src="{{asset('images/logo-white1.webp')}}" alt="" >
                                    </a>
                                </div>
                                <!-- logo close -->
                            </div>
                            <div class="de-flex-col header-col-mid">
                                <ul id="mainmenu">
                                    <li><a class="menu-item" href="{{ route('rapha.home') }}">Home</a></li>
                                    <li><a class="menu-item" href="{{ route('rapha.rooms') }}">Rooms</a></li>
                                    <li><a class="menu-item" href="{{ route('rapha.gallery') }}">Gallery</a></li>
                                    <li><a class="menu-item" href="{{ route('rapha.about') }}">About Us</a></li>
                                    <li><a class="menu-item" href="{{ route('rapha.contact') }}">Contact</a></li>
                                    @guest
                                         <li><a href="{{ route('rapha.signup') }}" class="btn-main btn-line sign_up">Sign Up</a> </li>
                                        <li> <a href="{{ route('rapha.login') }}" class="btn-main btn-line ms-md-4 mt-4 log_in">Log In</a></li> 
                                    @endguest

                                     @auth
                                      @can('manage-regular')
                                          <li><a href="{{ route('dashboard') }}" class="btn-main btn-line sign_up">Dashboard</a> </li>
                                      @endcan
                                         
                                    @can('manage-admin')
                                        <li><a href="{{ route('admin-dashboard') }}" class="btn-main btn-line sign_up">Dashboard</a> </li>
                                    @endcan
                                    @endauth
                                   
                                    
                                </ul>
                            </div>
                            <div class="de-flex-col">
                                <div class="menu_side_area">
                                    @guest
                                    <a href="{{ route('rapha.signup') }}" class="btn-main btn-line">Sign Up</a>          
                                    <a href="{{ route('rapha.login') }}" class="btn-main btn-line ms-md-4">Log In</a>
                                    @endguest
                                     @auth
                                        @can('manage-regular')
                                            <a href="{{ route('dashboard') }}" class="btn-main btn-line">Dashboard</a>   
                                        @endcan
                                    
                                        @can('manage-admin')
                                            <a href="{{ route('admin-dashboard') }}" class="btn-main btn-line">Dashboard</a>
                                        @endcan
                                    @endauth
                                    <span id="menu-btn"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- header close -->

        {{ $body }}
<!-- footer begin -->
        <footer class="text-light section-dark">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-md-12">
                        <div class="d-lg-flex align-items-center justify-content-between text-center">
                            <div>
                                <h3 class="fs-20">Address</h3>
                                No. 1 Rapha Avenue<br>
                                Secretariat Road, Umuahia<br>
                                Abia State, Nigeria.
                            </div>
                            <div>
                                <img src="../images/logo-white1.webp" class="w-200px" alt=""><br>
                                <div class="social-icons mb-sm-30 mt-4">
                                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                                </div>

                            </div>
                            <div>
                                <h3 class="fs-20">Contact Us</h3>
                                0916 443 9220, 0904 621 0001<br>
                                raphahotelltd25@gmail.com 
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="subfooter">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            Copyright 2025 - Rapha by ECR-TS
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer close -->
    </div>

  
    
    <!-- Javascript Files
    ================================================== -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/designesia.js') }}"></script>
    <script src="{{ asset('js/swiper.js') }}"></script>
    <script src="{{ asset('js/custom-marquee.js') }}"></script>
    <script src="{{ asset('js/custom-swiper-2.js') }}"></script>

</body>

</html>