<x-head-two title="{{$header}}" description="{{$header}}">
  <x-slot name="body">
    <x-preloader></x-preloader>
    <div class="content animate__animated animate__fadeIn">
      <a href="{{ route('rapha.home') }}">
        <img class="logo-main mx-auto d-block mx-sm-0" src="{{asset('images/logo-white1.webp')}}" alt="logo" >
      </a>
      <div class="notice_container">
          <h4 class="text-center text-lg-start">
           {{$header}}
          </h4>

          {{-- verification form starts--}}
          <form action="{{ route($route,$profile->id) }}" method="post">
            @csrf
            @method('put')
            
               @if($name==="password")
               <div class="form-group">
                  <input type="password" name="{{ $name }}" id="password" class="form-control verificationInput" required placeholder="{{ $placeholder }}">
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
                  <input type="text" name="{{ $name }}" class="form-control verificationInput" required placeholder="{{ $placeholder }}">
                </div>
                @endif
               
            
      
            @if($errors->any())
              @foreach ( $errors->all() as $error)
                <div class="alert alert-danger mt-3">
                    {{ $error }}
                </div>
                        
              @endforeach
            @endif
            

            <input type="submit" class="btn mt-4 reg_btn text-light mx-auto d-block" value="Submit">
          </form>
         

          
     </div>
    </div>
      
  </x-slot>
</x-head-two>