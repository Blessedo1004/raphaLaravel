<x-user-layout title="Reservations">
  <x-slot name="content">
    <div class="container mt-5">
      {{-- reservation success alert --}}
      @if(session('reservationSuccess'))
            <div class="alert alert-success text-center col-md-8 mx-auto d-block">
              {{ session('reservationSuccess') }}
            </div>
      @endif

      {{-- reservation update alert --}}
      @if(session('reservationEditSuccess'))
        <div class="alert alert-success text-center col-md-8 mx-auto d-block">
          {{session('reservationEditSuccess')}}
        </div>
      @endif

        {{-- reservation delete alert --}}
      @if(session('reservationDeleteSuccess'))
        <div class="alert alert-success text-center col-md-8 mx-auto d-block">
          {{session('reservationDeleteSuccess')}}
        </div>
      @endif

      <div class="row justify-content-center">
        <div class="col-8">
          <div class="row justify-content-center">
            <x-reservation-nav :activePage="Route::currentRouteName()" page="reservations">
              Pending
            </x-reservation-nav>
              
            <x-reservation-nav :activePage="Route::currentRouteName()" page="active-reservations">
              Active
            </x-reservation-nav>

            <x-reservation-nav :activePage="Route::currentRouteName()" page="completed-reservations">
              Completed
            </x-reservation-nav>
          </div>
        </div>
        @if($route === "pending")
            <h6 class="text-center mt-5 text-danger col-sm-10 mx-auto d-block">Note: All pending reservations that haven't been cleared at the counter will expire 24 hours after the check-in-date. Please do well to visit the counter and check-in with your reservation details.</h6>
        @endif

        @foreach ($reservations as $reservation)
        <a href="{{ route($route, $reservation->id)}}" class="text-black mx-auto d-block col-11 col-md-8 reservation_div mt-4 py-2" title="Click to view reservation details">
            <h4 class="text-center">{{$reservation->room->name}}</h4>
            <h6 class="mt-3 text-center">{{$reservation->created_at}}</h6>
        </a>
        @endforeach
        
      </div>
    </div> 
     
 
    {{-- reservation details modal starts --}}
    @if(session('reservationModal'))
      <div class="modal_container">
          <div class="modal_content">
            <h1 class="text-end mb-3"><i class="fa-solid fa-xmark" id="reservationModalClose" title="close"></i></h1>
            <h4> <span class="name">Room Type : </span>{{$details->room->name}}</h4>
            <h4 class="mt-3"> <span class="name">Check In Date : </span>{{$details->check_in_date}}</h4>
            <h4 class="mt-3"> <span class="name">Check Out Date :</span> {{$details->check_out_date}}</h4>
            <h4 class="mt-3"> <span class="name">Reservation ID :</span> {{$details->reservation_id}}</h4>
            @if($route === "pending")
              <h4 class="mt-3"> <span class="name">Expiry Date :</span> {{$details->expires_at}}</h4>
              <div class="d-flex justify-content-center mt-4">
              <a href="{{ route('show-edit-reservation', $details->id) }}" class="btn reg_btn text-light">Edit</a>
              <a href="{{ route('show-delete-reservation', $details->id) }}" class="btn btn-danger ms-3">Delete</a>
            </div>
            @endif
            
            
          </div>
      </div>
      @endif
      {{-- reservation details modal ends --}}

      {{-- edit reservation modal starts --}}
      @if(session('showEditReservation'))
        <div class="modal_container">
          <div class="modal_content">
           <h1 class="text-end mb-3"><i class="fa-solid fa-xmark" id="reservationModalClose" title="close"></i></h1>
             <input type="hidden" value="{{ $pendingEdit->room_id }}" id="hiddenRoom">
             <input type="hidden" value="{{ $pendingEdit->check_in_date->format('Y-m-d') }}" id="hiddenCheckIn">
             <input type="hidden" value="{{$pendingEdit->check_out_date->format('Y-m-d') }}" id="hiddenCheckOut">
        {{-- Edit reservation form starts --}}
           <form action="{{ route('edit-reservation', $pendingEdit->id) }}" method="post">
            @csrf
            @method('put')
          <!-- Room Select starts -->
          <div class="form-group mt-5">
            <div class="reservation">
              <label for="room_id"><h5>Available Rooms:</h5></label>
              <select id="room_id" name="room_id" required class="edit_select @error('room_id') is-invalid @enderror">
                <option value="" selected disabled>Choose a room</option>
                @foreach ($rooms as $room)
                  <option value="{{ $room->id }}" {{ $room->id == old('room_id') || $room->id === $pendingEdit->room_id ? 'selected' : '' }} class="edit_select_room">{{$room->name . ' ' . '|'. ' ' . $room->guest_number . ' Guests'}}</option>
                @endforeach   
              </select>
            </div>  
              @error('room_id')
                <div class="invalid-feedback d-block mt-1 text-center">{{ $message }}</div>
              @enderror
          </div>  
          <!-- Room Select ends -->

          <!-- Check-in Date starts -->
          <div class="form-group mt-4">
            <div class="reservation">
              <label for="checkin_date"><h5>Check-in Date:</h5></label>
              <input type="date" name="check_in_date" id="check_in_date" min="{{ date('Y-m-d') }}" class="form-control @error('check_in_date') is-invalid @enderror" value="{{ old('check_in_date',$pendingEdit->check_in_date->format('Y-m-d') ) }}">
            </div>
              @error('check_in_date')
                <div class="invalid-feedback d-block mt-1 text-center">{{ $message }}</div>
              @enderror
            
          </div>
          <!-- Check-in Date ends -->

          <!-- Check-out Date starts -->
          <div class="form-group mt-4">
            <div class="reservation">
              <label for="checkout_date"><h5>Check-out Date:</h5></label>
              <input type="date" name="check_out_date" id="check_out_date" min="{{ date('Y-m-d') }}" class="form-control @error('check_out_date') is-invalid @enderror" value="{{ old('check_out_date',$pendingEdit->check_out_date->format('Y-m-d') )}}">
            </div>
              @error('check_out_date')
                <div class="invalid-feedback d-block mt-1 text-center">{{ $message }}</div>
              @enderror
          </div>
          <!-- Check-out Date ends -->

          <input type="submit" value="Submit" class="btn reg_btn text-white mt-5 mx-auto d-block submit_edit_reservation">
        </form>
        {{-- Edit reservation form ends --}}
          </div>
        </div>
       @endif

       {{-- delete modal starts --}}
    @if(session('showDeleteReservation'))
      <div class="modal_container">
          <div class="modal_content">
            <h4 class="text-danger"> Are you sure you want to delete this pending reservation?</h4>
             <div class="d-flex justify-content-center mt-4">
              <button class="btn reg_btn text-light" id="reservationModalClose">No</button>
              <form action="{{ route('delete-reservation', $pendingDelete->id) }}" method="post">
                @csrf
                @method('delete')
                <input type="submit" class="btn btn-danger ms-3" value="Delete">
              </form>
              
            </div>
          </div>
      </div>
      @endif
      {{-- delete reservation modal ends --}}
  </x-slot>
 
</x-user-layout>

   
   