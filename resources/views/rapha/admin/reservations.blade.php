<x-user-layout title="Reservations">
  <x-slot name="content">
    <div class="container mt-5">
      @if(session('checkinSuccess'))
        <div class="alert alert-success text-center">
          {{session('checkinSuccess')}}
        </div>
      @endif

       @if(session('checkoutSuccess'))
        <div class="alert alert-success text-center">
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

            <x-reservation-nav :activePage="Route::currentRouteName()" page="admin-cleared-reservations">
              Cleared
            </x-reservation-nav>
          </div>
        </div>

         <form action="{{ route('search', $searchWildcard) }}">
        @csrf
        <div class="col-11 col-sm-8 mt-4 mx-auto d-block">
          <div class="input-group m">
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

      @if($reservations->isEmpty())
        <h4>No reservations</h4>
        @else
        @foreach ($reservations as $reservation)
        <a href="{{ route($route, $reservation->id)}}" class="text-black mx-auto d-block col-11 col-md-8 reservation_div mt-4 py-2">
            <h4 class="text-center">{{$reservation->room->name}}</h4>
            <h6 class="mt-3 text-center">{{$reservation->created_at}}</h6>
        </a>
        @endforeach
      @endif
        
        
      </div>
    </div> 
  
    @if(session('reservationModal'))
      <div class="modal_container">
          <div class="modal_content">
            <h1 class="text-end mb-3"><i class="fa-solid fa-xmark" id="reservationModalClose" title="close"></i></h1>
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
          </div>
      </div>
      @endif
  </x-slot>
</x-user-layout>