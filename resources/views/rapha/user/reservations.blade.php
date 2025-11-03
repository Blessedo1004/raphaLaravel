<x-user-layout title="Reservations">
  <x-slot name="content">
    <div class="container mt-5">
      @if(session('reservationSuccess'))
            <div class="alert alert-success text-center">
              {{ session('reservationSuccess') }}
            </div>
      @endif
      <div class="row justify-content-center">
        <div class="col-8">
          <div class="row justify-content-center">
            <x-reservation-nav :activePage="Route::currentRouteName()" page="reservations">
              Pending
            </x-reservation-nav>
              
            <x-reservation-nav :activePage="Route::currentRouteName()" page="active">
              Active
            </x-reservation-nav>

            <x-reservation-nav :activePage="Route::currentRouteName()" page="cleared">
              Cleared
            </x-reservation-nav>
          </div>
        </div>
        @foreach ($reservations as $reservation)
        <a href="{{ route('pending', $reservation->id)}}" class="text-black mx-auto d-block col-11 col-md-8 reservation_div mt-4 py-2" title="Click to view reservation details">
            <h4 class="text-center">{{$reservation->room->name}}</h4>
            <h6 class="mt-3 text-center">{{$reservation->updated_at}}</h6>
        </a>
        @endforeach
        
      </div>
    </div> 

     <h6 class="text-center mt-5 text-danger">Note: All pending reservations that haven't been cleared at the counter will expire 24 hours after the check-in-date. Please do well to visit the counter and check-in with your reservation details.</h6>
    
 
    
    @if(session('reservationModal'))
      <div class="modal_container">
          <div class="modal_content">
            <h1 class="text-end mb-3"><i class="fa-solid fa-xmark" id="reservationModalClose" title="close"></i></h1>
            <h4>Room Type : {{$pending->room->name}}</h4>
            <h4>Check In Date : {{$pending->check_in_date}}</h4>
            <h4>Check Out Date : {{$pending->check_out_date}}</h4>
            <h4>Reservation ID : {{$pending->reservation_id}}</h4>
            <h4>Expiry Date : {{$pending->expires_at}}</h4>
          </div>
      </div>
      @endif
  </x-slot>
 
</x-user-layout>

   
   