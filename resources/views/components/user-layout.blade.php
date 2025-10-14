
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{ asset('images/icon1.png') }}" type="image/png" sizes="16x16">
  <title>{{ $title }} </title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

  <div class="container-fluid container-sm header py-2">
    <div class="row justify-content-center">
      <div class="col-9 col-sm-4">
        <img src="{{ asset('images/logo-white1.webp') }}" alt="logo" class="img-fluid mx-auto d-block mx-sm-0" style="height: 80px;">
      </div>
      <div class="col-12 col-sm-5 text-center text-sm-start">
         <h5> Welcome ,</h5> <h2> {{Auth::user()->last_name}}</h2>
      </div>
      <div class="col-7 col-sm-2">
        <form action="{{ route('logout') }}" method="post">
          @csrf
          <input type="submit" class="btn mt-4 bg-danger text-light mx-auto d-block mx-sm-0" value="Log Out">
        </form>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-lg-2 nav-column mt-4">
        <div class="row nav-row justify-content-center align-items-center">
          <div class="col-12 text-center">
             <h6><i class="fa-solid fa-grip"></i> Dashboard</h6> 
          </div>
          <div class="col-12 text-center">
             <h6><i class="fa-solid fa-calendar-week"></i> Make a Reservation</h6> 
          </div>
          <div class="col-12 text-center">
             <h6> <i class="fa-solid fa-calendar-days"></i> Reservations</h6> 
          </div>
          <div class="col-12 text-center">
             <h6> <i class="fa-solid fa-comment"></i> Write a Review</h6> 
          </div>
          <div class="col-12 text-center">
             <h6> <i class="fa-solid fa-comments"></i> Reviews</h6> 
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-10"></div>
    </div>
  </div>


 

   
</body>
</html>