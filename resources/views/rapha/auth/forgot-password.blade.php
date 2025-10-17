<x-head-two title="Verify Email" description="Forgot password">
  <x-slot name="body">
    <x-preloader></x-preloader>
    <div class="content animate__animated animate__fadeIn">
      <a href="{{ route('rapha.home') }}">
        <img class="logo-main mx-auto d-block mx-sm-0" src="{{asset('images/logo-white1.webp')}}" alt="logo" >
      </a>
      <div class="notice_container">
          <h4 class="text-center text-lg-start">
            Please enter your registered email address
          </h4>

          {{-- verification form starts--}}
          <form action="{{ route('forgotPassword') }}" method="post">
            @csrf
            <div class="form-group">
              <input type="email" name="email" class="form-control verificationInput" required placeholder="Enter email">
            </div>
      
            @if($errors->any())
              @foreach ( $errors->all() as $error)
                <div class="alert alert-danger mt-3">
                    {{ $error }}
                </div>
                        
              @endforeach
            @endif

            @if(session('emailFailed'))
              <div class="alert alert-danger mt-3">
                  {{ session('failed') }}
              </div>
              
            @endif
            

            <input type="submit" class="btn mt-4 reg_btn text-light mx-auto d-block" value="Submit">
          </form>
         

          
     </div>
    </div>
      
  </x-slot>
</x-head-two>