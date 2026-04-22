    <div> 
      {{-- @if ($showNotification)
          <div class="broadcast-div col-10 col-md-5 text-center py-1 mx-auto d-block mt-2" wire:click="refreshList">
              New reservation available - click to refresh
          </div>
      @endif --}}

        
        <form>
        @csrf
        <div class="col-11 col-sm-8 mt-4 mx-auto d-block">
          <div class="input-group">
            <input 
              type="text" 
              wire:model.live.debounce.500ms="searchTerm"
              class="bg-white form-control"
              placeholder="Type reservation id..."
            >
            <input type="submit" class="btn reg_btn text-light input-group-text" value="Search">
          </div>
          
         </div>
        </form>
      <div id="reservations-container">
      @if($reservations->isEmpty())
        <h4 class="text-center mt-4">No reservations found</h4>
      @else
        @foreach ($reservations->groupBy(function($reservation) {
            return $reservation->created_at->format('Y-m-d');
        }) as $date => $reservationsOnDate)
        <div class="col-12 bg-light mt-3 mx-auto d-block" wire:transition>
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
            <div class="text-black mx-auto d-block col-11 col-md-8 reservation_div mt-4 py-2 mb-3" wire:click="showDetails({{ $reservation->id }})">
                <div class="row justify-content-center">
                  <h5 class="col-12 col-sm-6 col-xl-4 text-center text-md-start">{{$reservation->user->last_name . " " . $reservation->user->first_name }}</h5>
                  <h5 class="col-12 col-sm-6 col-xl-4 text-center text-md-start">{{$reservation->room->name}}</h5>
                </div>
                
                <h6 class="mt-2 text-center">{{$reservation->created_at->format('g:i A')}}</h6>
            </div>
          @endforeach
          </div>
        @endforeach
        @if(method_exists($reservations, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $reservations->links() }}
        </div>
        @endif
      @endif
      </div>
        
      <!-- modal starts -->
       @if($modalShow)
      <div class="modal_container mt-4 mt-sm-0" wire:transition>
        <div class="modal_content">
            <h1 class="text-end mb-3">
                <i class="fa-solid fa-xmark" id="reservationModalClose" title="close" wire:click="closeModal"></i>
            </h1>
            <h4> <span class="name">Name : </span>{{$details->user->last_name . " " . $details->user->first_name}}</h4>
            <h4> <span class="name">Room Type : </span>{{$details->room->name}}</h4>
            <h4 class="mt-3"> <span class="name">Check In Date : </span>{{$details->check_in_date->format('F j, Y') }}</h4>
            <h4 class="mt-3"> <span class="name">Check Out Date :</span> {{$details->check_out_date->format('F j, Y') }}</h4>
            <h4 class="mt-3"> <span class="name">Number of Rooms :</span> {{$details->number_of_rooms}}</h4>
            <h4 class="mt-3"> <span class="name">Reservation ID :</span> {{$details->reservation_id}}</h4>
            <button class="reg_btn btn mx-auto d-block text-white mt-4 col-4" wire:click="checkIn({{ $details->id }})">Check In</button>

        </div>
      </div>
      @endif
      <!-- modal ends -->
</div> 
