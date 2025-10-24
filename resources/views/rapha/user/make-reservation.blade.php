<x-user-layout title="Make a Reservation">
  <x-slot name="content">
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-12">
          <!-- select a room -->
          <div class="form-group rooms_select">
            <label for="room_id"><h5>Available Rooms:</h5></label>
            <select id="room_id" name="room_id" required>
              <option value="" selected disabled>Choose a room</option>
              @foreach ($rooms as $room)
                <option value="{{ $room->id }}" {{ $room->id == old('room_id') ? 'selected' : '' }}>{{$room->name . ' ' . '|'. ' ' . $room->guest_number . ' Guests'}}</option>
              @endforeach
                
                    
            </select>

            
          </div>
        </div>
      </div>
    </div>
  </x-slot>
</x-user-layout>

