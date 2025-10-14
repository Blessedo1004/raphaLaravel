<x-head-two title="Reset Password" description="Reset password">
  <x-slot name="body">
    <x-preloader></x-preloader>
    <div class="content animate__animated animate__fadeIn">
      <div class="notice_container">
          <h4 class="text-center text-lg-start">
            Enter New Password
          </h4>

           @if (session('codeVerifySuccess'))
             <div class="alert alert-success mt-3">
                  {{ session('codeVerifySuccess') }}
              </div>
            @endif

          {{-- reset form starts--}}
          <form action="{{ route('resetPassword') }}" method="post">
            @csrf

            <input type="hidden" name="email" value="{{ old('email', $email ?? '') }}">
            
            <input type="hidden" name="code" value="{{ old('code', $code ?? '') }}">
            
             {{-- Password --}}
                    <div class="form-group">
                      <label for="password">New Password:</label>
                      <input 
                        type="password"
                        name="password"
                        id="password"
                        required
                        class="bg-white form-control"
                        placeholder="At least 8 characters"
                      >
                    </div>

                    {{-- Confirm Password --}}
                    <div class="form-group">
                      <label for="password_confirmation">Confirm Password:</label>
                      <input 
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        required
                        class="bg-white form-control"
                      >
                    </div>

                    <div class="form-group">
                      <input type="checkbox" id="showPasswordCheckbox">
                      <label>Show Password</label>
                    </div>

                    <input type="submit" class="btn mt-4 reg_btn text-light" value="Reset">
            
            @if($errors->any())
              @foreach ( $errors->all() as $error)
                <div class="alert alert-danger mt-3">
                    {{ $error }}
                </div>
                        
              @endforeach
            @endif
          </form>
         

          
     </div>
    </div>
      
  </x-slot>
</x-head-two>