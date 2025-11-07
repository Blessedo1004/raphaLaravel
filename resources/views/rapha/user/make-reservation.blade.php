<x-user-layout title="Make a Reservation">
  <x-slot name="content">
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-12">
          <h2 class="text-center"><strong>Make Reservation</strong></h2>
          {{-- Reservation form starts --}}
          <form action="{{ route('make-reservation') }}" method="post">
            @csrf
          <!-- Room Select starts -->
          <div class="form-group mt-5">
            <div class="reservation">
              <label for="room_id"><h5>Available Rooms:</h5></label>
              <select id="room_id" name="room_id" required class="@error('room_id') is-invalid @enderror">
                <option value="" selected disabled>Choose a room</option>
                @foreach ($rooms as $room)
                  <option value="{{ $room->id }}" {{ $room->id == old('room_id') || ($selectedRoom && $room->id === $selectedRoom->id) ? 'selected' : '' }}>{{$room->name . ' ' . '|'. ' ' . $room->guest_number . ' Guests'}}</option>
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
              <input type="date" name="check_in_date" id="check_in_date" min="{{ date('Y-m-d') }}" class="form-control @error('check_in_date') is-invalid @enderror" value="{{ old('check_in_date') }}">
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
              <input type="date" name="check_out_date" id="check_out_date" min="{{ date('Y-m-d') }}" class="form-control @error('check_out_date') is-invalid @enderror" value="{{ old('check_out_date') }}">
            </div>
              @error('check_out_date')
                <div class="invalid-feedback d-block mt-1 text-center">{{ $message }}</div>
              @enderror
          </div>
          <!-- Check-out Date ends -->

          <input type="submit" value="Make Reservation" class="btn reg_btn text-white mt-5 mx-auto d-block">
        </form>
        {{-- Reservation form ends --}}
        </div>

      </div>
    </div>
  </x-slot>
</x-user-layout>

