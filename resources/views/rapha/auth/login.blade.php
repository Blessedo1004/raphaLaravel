
<x-head-two title="Log In" description="Log in to your Rapha Hotel account to make reservations and more">

<x-slot name="body">
  <!-- page preloader begin -->
        <div id="de-loader"></div>
        <!-- page preloader close -->
  {{-- content starts --}}
  @if(session('verifiedSuccess'))
    <div class="alert alert-success text-center">
      {{session('verifiedSuccess')}}
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
                      value="{{ old('login') }}"
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
                      <input type="submit" class="btn mt-4 reg_btn text-light col-9" value="Log In">
                    </div>
                    <div class="col-12">
                      <a href="{{ route('rapha.signup') }}" class="url">Don't have an account? Sign up</a>
                    </div>
                    
                    <!-- validation errors -->
                    @if($errors->any())
                      @foreach ($errors->all() as $error)
                        <div class="alert alert-danger mt-3">
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
  {{-- content ends --}}

  <script src="{{ asset('js/plugins.js') }}"></script>
  </x-slot>
</x-head-two>