
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ asset('images/icon1.png') }}" type="image/png" sizes="16x16">
  <title>{{ $title }} </title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
@if(session('loginSuccess'))

  <div class="alert alert-success text-center">
       {{session('loginSuccess')}}
  </div>
  
@endif

  <!-- page preloader begin -->
          <x-preloader></x-preloader>
  <!-- page preloader close -->

   <div class="content animate__animated animate__fadeIn" style="position: relative;">
  {{-- header starts --}}
  <div class="container-fluid container-sm header py-2">
    <div class="row justify-content-center">
      <div class="col-9 col-sm-4">
        <a href="{{ route('rapha.home') }}">
          <img src="{{ asset('images/logo-white1.webp') }}" alt="logo" class="img-fluid mx-auto d-block mx-sm-0">
        </a>
        
      </div>
      <div class="col-12 col-sm-5 text-sm-start mt-2">
        <div class="row justify-content-center justify-content-md-start align-items-center">
          <div class="col-7 col-md-12">
            <h5> Welcome ,</h5> <h2> {{Auth::user()->last_name}}</h2> 
          </div>
          <h1 class="col-1 col-md-12"><i class="fa-solid fa-bars"></i> <i class="fa-solid fa-xmark"></i></h1>
        </div>
         
      </div>
      <div class="col-7 col-sm-2">
        <form action="{{ route('logout') }}" method="post">
          @csrf
          <input type="submit" class="btn mt-4 bg-danger text-light mx-auto d-block mx-sm-0" value="Log Out">
        </form>
      </div>
    </div>
  </div>
  {{-- header ends --}}

  {{-- navigation starts --}}
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-lg-2 nav-column mt-4">
        <div class="row nav-row justify-content-center align-items-center">
          <div class="col-12 text-center">
            <x-nav :activePage="Route::currentRouteName()" page="dashboard">
              <i class="fa-solid fa-grip"></i> Dashboard
            </x-nav>
          </div>
          <div class="col-12 text-center">
            <x-nav :activePage="Route::currentRouteName()" page="make-reservation">
              <i class="fa-solid fa-calendar-week"></i> Make Reservation
            </x-nav>
          </div>
          <div class="col-12 text-center">
             <x-nav :activePage="Route::currentRouteName()" page="reservations">
              <i class="fa-solid fa-calendar-days"></i> Reservations
            </x-nav>
           
          </div>
          <div class="col-12 text-center">
             <x-nav :activePage="Route::currentRouteName()" page="write-review">
               <i class="fa-solid fa-comment"></i> Write a Review
            </x-nav>
          </div>
          {{-- <div class="col-12 text-center">
             <x-nav :activePage="Route::currentRouteName()" page="reviews">
               <i class="fa-solid fa-comments"></i> My Review
            </x-nav>
          </div> --}}

          <div class="col-12 text-center">
             <x-nav :activePage="Route::currentRouteName()" page="profile">
               <i class="fa-solid fa-user-tie"></i> User Profile
            </x-nav>
          </div>
        </div>
      </div>
      {{-- navigation ends --}}

      {{-- content starts --}}
      <div class="col-12 col-lg-10 content-div pb-5 pb-lg-0">
        {{ $content }}
      </div>
      {{-- content ends --}}
    </div>
  </div>
  </div>

  <script>
        window.loginUrl = "{{ route('login') }}";
    </script>
   <script src="{{ asset('js/main.js') }}?v={{ filemtime(public_path('js/main.js')) }}"></script>
</body>
</html>