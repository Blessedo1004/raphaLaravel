<x-head-two title="Verify Email" description="zzzzzz">
  <x-slot name="body">
    <x-preloader></x-preloader>
    <div class="content animate__animated animate__fadeIn">
      <img class="logo-main mx-auto d-block mx-sm-0" src="{{asset('images/logo-white1.webp')}}" alt="logo" >
       <div class="notice_container">
          <h4 class="text-center text-lg-start">
            We've sent a verification code to {{ $email }}. Please check your inbox or spam folder and type in the code below.
          </h4>

          {{-- verification form starts--}}
          <form action="{{ route('preregister.verify') }}" method="post">
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
            

            <input type="submit" class="btn mt-4 reg_btn text-light mx-auto d-block" value="Submit">
          </form>
          <h4 class="mt-4 text-center text-lg-start">
            Didn't recieve an email? Click the button below to request for another code.
          </h4>

          {{-- resend button--}}
          <form action="{{ route('preregister.resend') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="submit" class="btn mt-4 reg_btn text-light mx-auto d-block" value="Resend Code">
            @if(session('resendSuccess'))
              <div class="alert alert-success mt-3">
                  {{ session('resendSuccess') }}
              </div>
              
            @endif
          </form>
     </div>
    </div>
     
  </x-slot>
</x-head-two>