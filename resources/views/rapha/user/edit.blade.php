<x-head-two title="{{$header}}">
  <x-slot name="body">
    <x-preloader></x-preloader>
    <div class="content animate__animated animate__fadeIn">
      <div class="notice_container">
          <a href="{{ route('rapha.home') }}">
            <img class="logo-main mx-auto d-block mx-sm-0" src="{{asset('images/logo-white1.webp')}}" alt="logo" >
          </a>  
          <h5 class="text-center text-lg-start mt-3">
           {{$header}}
          </h5>

          @if($name!="password")
          <input type="hidden" value="{{ $profile->$name }}" id="inputHidden">
          @endif
          {{-- verification form starts--}}
          <form action="{{ route($route,$profile->id) }}" method="post">
            @csrf
            @method('put')
            
               @if($name==="password")
               <div class="form-group">
                  <input type="password" name="{{ $name }}" id="password" class="form-control verificationInput @error('password') is-invalid @enderror" required placeholder="{{ $placeholder }}">
                  @error('password')
                        <div class="invalid-feedback mt-1 ">
                          {{ $message }}
                        </div>
                   @enderror
              </div>
              <div class="form-group">
                  <input type="password" name="password_confirmation" id="password_confirmation" class="form-control verificationInput mt-3" required placeholder="Confirm password">
              </div>
               <div class="form-group">
                    <input type="checkbox" id="showPasswordCheckbox">
                    <label>Show Password</label>
                </div>

                @else

                <div class="form-group">
                  <input type="text" name="{{ $name }}" class="form-control verificationInput @error($name) is-invalid @enderror" required placeholder="{{ $placeholder }}" id="editInput">
                  @error($name)
                        <div class="invalid-feedback mt-1 ">
                          {{ $message }}
                        </div>
                  @enderror
                  <p class="edit_error_message text-danger mt-2"></p>
                </div>
                @endif
               
            <input type="submit" class="btn mt-4 reg_btn text-light mx-auto d-block" value="Submit" id="editBtn">
          </form>
         

          
     </div>
    </div>
      
  </x-slot>
</x-head-two>