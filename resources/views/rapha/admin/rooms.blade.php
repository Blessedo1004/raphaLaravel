<x-user-layout title="Rooms">
  <x-slot name="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-9 mx-auto d-block">
          @if(session('changeSuccessfull'))
            <div class="alert alert-success text-center col-md-8 mx-auto d-block">
              {{session('changeSuccessfull')}}
           </div>
          @endif
        </div>
        <h4 class="text-center mt-5">Total Rooms: {{ $rooms->count() }}</h4>  
        <div class="col-9 mx-auto d-block mt-3 table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Room Name</th>
                <th>Guest Number</th>
                <th>Availability</th>
                <th>Action</th>
              </tr>
              
              <tbody>
                @foreach ($rooms as $room)
                <tr>
                    <td>{{$room->name}}</td>
                    <td>{{$room->guest_number}}</td>
                    <td>{{$room->availability}}</td>
                    <td>
                      <a href="{{ route('edit-room-availability', $room->id) }}">
                        <i class="fa-solid fa-user-pen" title="Edit {{ $room->name }} Availability"></i>
                      </a>
                    </td>
                </tr>
                @endforeach 
              </tbody>
            </thead>
          </table>
          <div class="d-flex justify-content-center mt-4">
              {{ $rooms->links() }}
          </div>
        </div>
      </div>
    </div>
  </x-slot>  
</x-user-layout>


