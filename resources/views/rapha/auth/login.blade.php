
<x-head-two title="Log In" description="Log in to your Rapha Hotel account to make reservations and more">

<x-slot name="body">
      <!-- page preloader begin -->
          <x-preloader></x-preloader>
      <!-- page preloader close -->

      <div class="content animate__animated animate__fadeIn">
        {{-- content starts --}}
      @if(session('verifiedSuccess'))
        <div class="alert alert-success text-center">
          {{session('verifiedSuccess')}}
        </div>
      @endif

      @if(session('logoutSuccess'))

      <div class="alert alert-success text-center">
          {{session('logoutSuccess')}}
      </div>
      
      @endif

      @if(session('resetSuccess'))
        <div class="alert alert-success text-center">
          {{session('resetSuccess')}}
        </div>
      @endif
      
      
      @if(session('deleteAccountSuccess'))
        <div class="alert alert-success text-center">
          {{session('deleteAccountSuccess')}}
        </div>
      @endif
        <div class="container-fluid p-0 details">
            <div class="row g-0">
              <div class="col-12 col-lg-6 img_col">
                <img src="{{ asset('images/gallery/F3.webp') }}" alt="img" class="img-fluid display_img">
              </div>
              <div class="col-12 col-lg-6 form_section">
                <div class="row mt-5 offset-lg-2">
          
                    <a href="{{ route('rapha.home') }}" class="url mt-5 mt-lg-0">Back To Home</a>
                    {{-- Form starts --}}
                      <form action="{{ route('rapha.login') }}" method="POST" class="mt-5">
                        @csrf

                        <h1 class="mt-4">Login</h1>
                        
                        

                        {{-- Username  or email  --}}
                        <div class="form-group">
                          <label for="username">Username or Email:</label>
                        <input 
                          type="text"
                          name="login"
                          value="{{ old('user_name') ? old('user_name') : old('email') }}"
                          required
                          class="bg-white form-control"
                        >
                        </div>


                        {{-- Password --}}
                        <div class="form-group">
                          <label for="password">Password:</label>
                          <input 
                            type="password"
                            name="password"
                            id="password"
                            required
                            class="bg-white form-control"
                          >
                        </div>

                        <div class="form-group">
                          <input type="checkbox" id="showPasswordCheckbox">
                          <label>Show Password</label>
                        </div>
                        <div class="col-12">
                          <input type="submit" class="btn mt-4 reg_btn text-light  col-7 col-md-6 col-lg-9" value="Log In">
                        </div>
                        <div class="col-8 col-sm-7 col-md-6 col-lg-9 mt-3 text-center">
                          <a href="{{ route('rapha.signup') }}" class="url">Don't have an account? Sign up</a>
                        </div>
                        
                        <div class="col-8 col-sm-7 col-md-6 col-lg-9 mt-3 text-center">
                          <a href="{{ route('forgotPassword') }}" class="url">Forgot password?</a>
                        </div>
                        <!-- validation errors -->
                        @if($errors->any())
                          @foreach ($errors->all() as $error)
                            <div class="alert alert-danger col-8 col-md-6 col-lg-9 mt-3 text-center mb-5">
                              {{ $error }}
                            </div>
                            
                          @endforeach
                        @endif
                      </form>
                      {{-- Form ends --}}
                
                </div>
          

              </div>
            </div>
        </div>
      </div>
      {{-- content ends --}}

 
  </x-slot>
</x-head-two>