<x-head-two title="{{$title}}">
  <x-slot name="body">
    <x-preloader></x-preloader>
    <div class="content animate__animated animate__fadeIn">
      <div class="notice_container">
          <a href="{{ route('rapha.home') }}">
            <img class="logo-main mx-auto d-block mx-sm-0" src="{{asset('images/logo-white1.webp')}}" alt="logo" >
          </a>  


         
          <input type="hidden" value="{{ $room->availability}}" id="inputHidden">
  
          {{-- verification form starts--}}
          <form action="{{ route('edit-room-availability',$room->id) }}" method="post">
            @csrf
            @method('put')

                <div class="form-group">
                  <input type="number" name="availability" class="form-control verificationInput @error('availability') is-invalid @enderror" required placeholder="Type new availability" id="editInput">
                  @error('availability')
                        <div class="invalid-feedback mt-1 ">
                          {{ $message }}
                        </div>
                  @enderror
                  <p class="edit_error_message text-danger mt-2"></p>
                </div>
               
            <input type="submit" class="btn mt-4 reg_btn text-light mx-auto d-block" value="Change {{ $room->name }} Availability" id="editBtn">
          </form>
         

          
     </div>
    </div>
      
  </x-slot>
</x-head-two>