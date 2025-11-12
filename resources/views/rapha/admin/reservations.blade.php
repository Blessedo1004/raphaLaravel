<x-user-layout title="Reservations">
  <x-slot name="content">
    <div class="container mt-5">
      @if(session('checkinSuccess'))
        <div class="alert alert-success text-center col-md-8 mx-auto d-block">
          {{session('checkinSuccess')}}
        </div>
      @endif

       @if(session('checkoutSuccess'))
        <div class="alert alert-success text-center col-md-8 mx-auto d-block">
          {{session('checkoutSuccess')}}
        </div>
      @endif
      <div class="row justify-content-center">
        <div class="col-8">
          <div class="row justify-content-center">
            <x-reservation-nav :activePage="Route::currentRouteName()" page="admin-reservations">
              Pending
            </x-reservation-nav>
              
            <x-reservation-nav :activePage="Route::currentRouteName()" page="admin-active-reservations">
              Active
            </x-reservation-nav>

            <x-reservation-nav :activePage="Route::currentRouteName()" page="admin-completed-reservations">
              Completed
            </x-reservation-nav>
          </div>
        </div>

         <form action="{{ route('search', $searchWildcard) }}">
        @csrf
        <div class="col-11 col-sm-8 mt-4 mx-auto d-block">
          <div class="input-group">
            <input 
              type="text" 
              id="search" 
              name="search" 
              value=""
              class="bg-white form-control"
              placeholder="Type reservation id..."
            >
            <input type="submit" class="btn reg_btn text-light input-group-text" value="Search">
          </div>
          
        </div>
      </form>

      @if($groupedReservations->isEmpty())
        <h4 class="text-center mt-4">No reservations found</h4>
      @else
        @foreach ($groupedReservations as $date => $reservationsOnDate)
        <div class="reservation_container col-12 col-lg-10 bg-light mt-2">
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
            <a href="{{ route($route, $reservation->id)}}" class="text-black mx-auto d-block col-11 col-md-8 reservation_div mt-4 py-2 mb-3">
                <div class="row justify-content-center">
                  <h4 class="col-12 col-sm-6 col-xl-4 text-center text-md-start">{{$reservation->user->last_name . " " . $reservation->user->first_name }}</h4>
                  <h4 class="col-12 col-sm-6 col-xl-4 text-center text-md-start">{{$reservation->room->name}}</h4>
                </div>
                
                <h6 class="mt-2 text-center">{{$reservation->created_at->format('g:i A')}}</h6>
            </a>
          @endforeach
          </div>
        @endforeach
      @endif
        
        
      </div>
    </div> 
  
    @if(session('reservationModal'))
      <x-reservation-modal>
            <h4> <span class="name">Name : </span>{{$details->user->last_name . " " . $details->user->first_name}}</h4>
             <h4> <span class="name">Room Type : </span>{{$details->room->name}}</h4>
            <h4 class="mt-3"> <span class="name">Check In Date : </span>{{$details->check_in_date}}</h4>
            <h4 class="mt-3"> <span class="name">Check Out Date :</span> {{$details->check_out_date}}</h4>
            <h4 class="mt-3"> <span class="name">Reservation ID :</span> {{$details->reservation_id}}</h4>
            @if($route === "admin-pending")
              <h4 class="mt-3"> <span class="name">Expiry Date :</span> {{$details->expires_at}}</h4>
              <a href="{{ route('checkin', $details->id) }}" class="reg_btn btn mx-auto d-block text-white mt-4 col-4">Check In</a>

              @elseif($route === "admin-active")
              <a href="{{ route('checkout', $details->id) }}" class="reg_btn btn mx-auto d-block text-white mt-4 col-4">Check Out</a>
            @endif
      </x-reservation-modal>
      @endif
  </x-slot>
</x-user-layout>