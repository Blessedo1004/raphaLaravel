<x-user-layout title="Reservations">
  <x-slot name="content">
    <div class="container mt-5">
      {{-- reservation success alert --}}
        <div class="col-9 mx-auto d-block">
          @if(session('reservationSuccess'))
            <div class="alert alert-success text-center col-md-8 mx-auto d-block">
              {{session('reservationSuccess')}}
           </div>
          @endif
        </div>

      {{-- reservation update alert --}}
        <div class="col-9 mx-auto d-block">
          @if(session('reservationEditSuccess'))
            <div class="alert alert-success text-center col-md-8 mx-auto d-block">
              {{session('reservationEditSuccess')}}
           </div>
          @endif
        </div>

        {{-- reservation delete alert --}}
        <div class="col-9 mx-auto d-block">
          @if(session('reservationDeleteSuccess'))
            <div class="alert alert-success text-center col-md-8 mx-auto d-block">
              {{session('reservationDeleteSuccess')}}
           </div>
          @endif
        </div>

      <div class="row justify-content-center">
        <div class="col-12 col-md-8 reservation_col">
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
          
        @if($route === "pending")
            <h6 class="text-center mt-5 text-danger col-sm-8 mx-auto d-block">Note: All pending reservations that haven't been cleared at the counter will expire 24 hours after the check-in-date (WAT). Please do well to visit the counter and check-in with your reservation details.</h6>
        @endif
        </div>
      </div>
        @if($reservations->isEmpty())
          <h4 class="text-center mt-5">No reservations found</h4>
        @else
          @foreach ($reservations->groupBy(function($reservation) {
              return $reservation->created_at->format('Y-m-d');
          }) as $date => $reservationsOnDate)
            <div class="reservation_container col-12 col-lg-10 bg-light mt-4">
              <h3 class="text-center mt-2 date_heading">
                @if(Carbon\Carbon::parse($date)->isToday())
                  Today
                @elseif(Carbon\Carbon::parse($date)->isYesterday())
                  Yesterday
                @else
                  {{ Carbon\Carbon::parse($date)->format('F j, Y') }}
                @endif
              </h3>
              @foreach ($reservationsOnDate as $reservation)
                <a href="{{ route($route, $reservation->id)}}" class="text-black mx-auto d-block col-11 col-md-8 reservation_div py-2 mt-4 mb-3" title="Click to view reservation details">
                  <h4 class="text-center">{{$reservation->room->name}}</h4>
                  <h6 class="mt-3 text-center">{{$reservation->created_at->format('g:i A')}}</h6>
                </a>
              @endforeach
            </div>
          @endforeach
          <div class="d-flex justify-content-center mt-4">
              {{ $reservations->links() }}
          </div>
        @endif
        
      </div>
    </div> 
     
 
    {{-- reservation details modal starts --}}
    @if(session('reservationModal'))
      <x-reservation-modal>
          <x-slot name="close">
            <i class="fa-solid fa-xmark" id="reservationModalClose" title="close"></i>
          </x-slot> 
          <x-slot name="modalContent">
            <h4> <span class="name">Room Type : </span>{{$details->room->name}}</h4>
            <h4 class="mt-3"> <span class="name">Check In Date : </span>{{$details->check_in_date->format('F j, Y') }}</h4>
            <h4 class="mt-3"> <span class="name">Check Out Date :</span> {{$details->check_out_date->format('F j, Y') }}</h4>
            <h4 class="mt-3"> <span class="name">Number of Rooms :</span> {{$details->number_of_rooms}}</h4>
            <h4 class="mt-3"> <span class="name">Reservation ID :</span> {{$details->reservation_id}}</h4>
            @if($route === "pending")
              <h4 class="mt-3"> 
                  <span class="name">Expiry Date :</span> {{$details->expires_at}}
              </h4>
              <div class="d-flex justify-content-center mt-4">
                 <a href="{{ route('show-edit-reservation', $details->id) }}" class="btn reg_btn text-light">Edit</a>
                 <a href="{{ route('show-delete-reservation', $details->id) }}" class="btn btn-danger ms-3">Delete</a>
              </div>
            @endif
         </x-slot>   
      </x-reservation-modal>
      @endif
      {{-- reservation details modal ends --}}

      {{-- edit reservation modal starts --}}
      @if(session('showEditReservation'))
        <x-reservation-modal>
          <x-slot name="close">
            <i class="fa-solid fa-xmark" id="reservationModalClose" title="close"></i>
          </x-slot> 
          <x-slot name="modalContent">
             <input type="hidden" value="{{ $pendingEdit->room_id }}" id="hiddenRoom" name="old_room_id">
             <input type="hidden" value="{{ $pendingEdit->check_in_date->format('Y-m-d') }}" id="hiddenCheckIn">
             <input type="hidden" value="{{$pendingEdit->check_out_date->format('Y-m-d') }}" id="hiddenCheckOut">
             <input type="hidden" id="hiddenNumberOfRooms" value="{{ $pendingEdit->number_of_rooms }}">
        {{-- Edit reservation form starts --}}
           <form action="{{ route('edit-reservation', $pendingEdit->id) }}" method="post">
            @csrf
            @method('put')
          <!-- Room Select starts -->
          <div class="form-group mt-5">
            <div class="reservation">
              <label for="room_id"><h5>Rooms:</h5></label>
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

           <!-- Availability starts-->
          <div class="text-center mt-4">
            <h5>Availability: 
              <span id="room-availability" class="text-muted">
                Select a room to see its availability
              </span>
            </h5>
          </div>
          <!-- Availability ends-->

          <!-- Number of Rooms starts -->
            <div class="text-center mt-4">
              <h5>Number of Rooms: 
                <i class="fa-solid fa-minus" id="minus"></i>
                <span id="number_of_rooms">{{$pendingEdit->number_of_rooms}}</span> 
                <i class="fa-solid fa-plus" id="plus"></i>
              </h5>
            </div>
          <input type="hidden" name="number_of_rooms" id="number_of_rooms_input" value="{{ $pendingEdit->number_of_rooms }}">
          
          <!-- Number of Rooms ends -->

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
        </x-slot> 
        </x-reservation-modal>
       @endif
        {{-- edit reservation modal ends --}}

       {{-- delete reservation modal starts --}}
    @if(session('showDeleteReservation'))
    <x-reservation-modal>
       <x-slot name="modalContent">
            <h4 class="text-danger"> Are you sure you want to delete this pending reservation?</h4>
             <div class="d-flex justify-content-center mt-4">
              <button class="btn reg_btn text-light" id="reservationModalClose">No</button>
              <form action="{{ route('delete-reservation', $pendingDelete->id) }}" method="post">
                @csrf
                @method('delete')
                <input type="submit" class="btn btn-danger ms-3" value="Delete">
              </form>
              
            </div>
        </x-slot>     
      </x-reservation-modal>
      @endif
      {{-- delete reservation modal ends --}}
  </x-slot>
 
</x-user-layout>

   
   