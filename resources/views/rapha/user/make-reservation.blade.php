<x-user-layout title="Make a Reservation">
  <x-slot name="content">
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-12">
          {{-- Reservation form starts --}}
          <form action="" method="post">
          <!-- Room Select starts -->
          <div class="form-group reservation">
            <label for="room_id"><h5>Available Rooms:</h5></label>
            <select id="room_id" name="room_id" required>
              <option value="" selected disabled>Choose a room</option>
              @foreach ($rooms as $room)
                <option value="{{ $room->id }}" {{ $room->id == old('room_id') ? 'selected' : '' }}>{{$room->name . ' ' . '|'. ' ' . $room->guest_number . ' Guests'}}</option>
              @endforeach   
            </select>
          </div>
          <!-- Room Select starts -->

          <!-- Check-in Date starts -->
          <div class="form-group reservation mt-4">
            <label for="checkin_date"><h5>Check-in Date:</h5></label>
            <input type="date" name="check_in_date" id="check_in_date" min="{{ date('Y-m-d') }}">
          </div>
          <!-- Check-in Date ends -->

          <!-- Check-out Date starts -->
          <div class="form-group reservation mt-4">
            <label for="checkout_date"><h5>Check-out Date:</h5></label>
            <input type="date" name="check_out_date" id="check_out_date" min="{{ date('Y-m-d') }}">
          </div>
          <!-- Check-out Date ends -->

          <input type="submit" value="Make Reservation" class="btn reg_btn text-white mt-4 mx-auto d-block">

         <!-- validation errors -->
          @if($errors->any())
            @foreach ($errors->all() as $error)
              <div class="alert alert-danger mt-3 col-12">
                {{ $error }}
              </div>
              
            @endforeach
          @endif
        </form>
        {{-- Reservation form ends --}}
        </div>

      </div>
    </div>
  </x-slot>
</x-user-layout>

