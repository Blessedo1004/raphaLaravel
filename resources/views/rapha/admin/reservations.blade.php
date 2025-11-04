<x-user-layout title="Reservations">
  <x-slot name="content">
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-8">
          <div class="row justify-content-center">
            <x-reservation-nav :activePage="Route::currentRouteName()" page="admin-reservation">
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
        <a href="{{ route('admin-pending', $reservation->id)}}" class="text-black mx-auto d-block col-11 col-md-8 reservation_div mt-4 py-2">
            <h4 class="text-center">{{$reservation->room->name}}</h4>
            <h6 class="mt-3 text-center">{{$reservation->updated_at}}</h6>
        </a>
        @endforeach
        
      </div>
    </div> 
  
    @if(session('reservationModal'))
      <div class="modal_container">
          <div class="modal_content">
            <h1 class="text-end mb-3"><i class="fa-solid fa-xmark" id="reservationModalClose" title="close"></i></h1>
             <h4> <span class="name">Room Type : </span>{{$pending->room->name}}</h4>
            <h4 class="mt-3"> <span class="name">Check In Date : </span>{{$pending->check_in_date}}</h4>
            <h4 class="mt-3"> <span class="name">Check Out Date :</span> {{$pending->check_out_date}}</h4>
            <h4 class="mt-3"> <span class="name">Reservation ID :</span> {{$pending->reservation_id}}</h4>
            <h4 class="mt-3"> <span class="name">Expiry Date :</span> {{$pending->expires_at}}</h4>
          </div>
      </div>
      @endif
  </x-slot>
</x-user-layout>