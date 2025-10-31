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
        <a href="{{ url('/user/reservations/pending/' . $reservation->id )}}" class="text-black mx-auto d-block col-11 col-md-8 reservation_div mt-4 py-2">
            <h4 class="text-center">{{$reservation->room->name}}</h4>
            <h6 class="mt-3 text-center">{{$reservation->updated_at}}</h6>
        </a>
        @endforeach
        
      </div>
    </div> 

    <x-slot name="reservationContent">
      <!-- Modal body -->
        <div class="modal-body">
          <h4></h4>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn reg_btn text-white" data-bs-dismiss="modal">Ok</button>
          
        </div>
    </x-slot>
  
    
    
  </x-slot>
  @if(session('reservationModal'))
      <div class="modal" id="reservationModal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            mmm
            {{ $reservationContent ?? ''}}
          </div>
        </div>
      </div>
      @endif
</x-user-layout>