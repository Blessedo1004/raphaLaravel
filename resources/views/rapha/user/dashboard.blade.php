<x-user-layout title="Dashboard">

  <x-slot name="content">
    <div class="container mt-5">
    <div class="row justify-content-center dashboard_row">
      <div class="col-12 col-md-4 col-lg-3 dashboard_item py-3">
        <div class="col-12">
          <h4 class="text-center">Total Pending Reservations:</h4>
        </div>
         <div class="mt-3 total_border mx-auto d-block"></div>
         <h5 class="text-center total">{{$pending}}</h5>
      </div>

      <div class="col-12 col-md-4 col-lg-3 dashboard_item py-3 mt-3 mt-md-0">
        <div class="col-12">
          <h4 class="text-center">Total Active Reservations:</h4>
        </div>
         <div class="mt-3 total_border mx-auto d-block"></div>
         <h5 class="text-center total">{{$active}}</h5>
      </div>
      
      <div class="col-12 col-md-4 col-lg-3 dashboard_item py-3 mt-3 mt-md-0">
        <div class="col-12">
          <h4 class="text-center">Total Completed Reservations:</h4>
        </div>
         <div class="mt-3 total_border mx-auto d-block"></div>
         <h5 class="text-center total">{{$completed}}</h5>
      </div>
    </div>
    </div>

    <div class="container">
      <div class="row d-flex justify-content-center">
         <h2 class="text-center mt-5"><strong>Latest Pending Reservations</strong></h2>
       @if($latestPendingReservations->isEmpty())
        <h4 class="text-center mt-4">No reservations found</h4>
      @else
        @foreach ($latestPendingReservations->groupBy(function($reservation) {
            return $reservation->created_at->format('Y-m-d');
        }) as $date => $reservationsOnDate)
        <div class="col-12 col-lg-10 bg-light mt-3">
          <h3 class="text-center mt-5 date_heading">
            @if(Carbon\Carbon::parse($date)->isToday())
              Today
            @elseif(Carbon\Carbon::parse($date)->isYesterday())
              Yesterday
            @else
              {{ Carbon\Carbon::parse($date)->format('F j, Y') }}
            @endif
          </h3>
          @foreach ($reservationsOnDate as $reservation)
            <div class="text-black mx-auto d-block col-11 col-md-8 reservation_div mt-4 py-2 mb-3">
                <div class="row justify-content-center">
                  <h5 class="col-12 col-sm-6 col-xl-4 text-center text-md-start">{{$reservation->user->last_name . " " . $reservation->user->first_name }}</h5>
                  <h5 class="col-12 col-sm-6 col-xl-4 text-center text-md-start">{{$reservation->room->name}}</h5>
                </div>
                
                <h6 class="mt-2 text-center">{{$reservation->created_at->format('g:i A')}}</h6>
              </div>
          @endforeach
          </div>
        @endforeach
      @endif
      <h6 class="text-center"><a href="{{ route('admin-reservations') }}" class="url">View All Reservations</a></h6>
      </div>
    </div>
  </x-slot>
  
</x-user-layout>

