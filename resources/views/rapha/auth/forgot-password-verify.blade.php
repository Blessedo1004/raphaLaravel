<x-head-two title="Forgot Password">
  <x-slot name="body">
    <x-preloader></x-preloader>
    <div class="content animate__animated animate__fadeIn">
      <div class="notice_container">
         <a href="{{ route('rapha.home') }}">
            <img class="logo-main mx-auto d-block mx-sm-0" src="{{asset('images/logo-white1.webp')}}" alt="logo" >
         </a>
          <h5 class="text-center text-lg-start mt-3">
            We've sent you a password reset code. Please check your inbox or spam folder and type in the code below.
          </h5>

          {{-- verification form starts--}}
          <form action="{{ route('forgotpassword.verify') }}" method="post">
            @csrf
            <div class="form-group">
              <input type="text" name="code" class="form-control verificationInput" required placeholder="Enter verification code">
            </div>
      
            @if($errors->any())
              @foreach ( $errors->all() as $error)
                <div class="alert alert-danger mt-3">
                    {{ $error }}
                </div>
                        
              @endforeach
            @endif

            @if(session('failed'))
              <div class="alert alert-danger mt-3">
                  {{ session('failed') }}
              </div>
              
            @endif
            

            <input type="submit" class="btn mt-4 reg_btn text-light mx-auto d-block" value="Verify Email">
          </form>
          
          <h5 class="mt-4 text-center text-lg-start">
            Didn't recieve an email? Click the button below to request for another code.
          </h5>

          {{-- resend button--}}
           <form action="{{ route('forgot-password.resend') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ old('email', $email ?? '') }}">
            <button type="submit" class="btn mt-4 reg_btn text-light mx-auto d-block" id="resendCodeButton" disabled>Resend Code <span class="resend_countdown">(<span class="resend_countdown_value">59</span>)</span></button>
            @if(session('resendSuccess2'))
              <div class="alert alert-success mt-3">
                  {{ session('resendSuccess2') }}
              </div>
              
            @endif
          </form>
     </div>
    </div>
      
  </x-slot>
</x-head-two>