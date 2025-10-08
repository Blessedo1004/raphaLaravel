
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

                    <h2 class="mt-4">Login</h2>
                    
                    

                    {{-- Username --}}
                    <div class="form-group">
                      <label for="username">Username:</label>
                    <input 
                      type="text"
                      name="user_name"
                      value="{{ old('user_name') }}"
                      required
                      class="bg-white form-control"
                    >
                    </div>

                    {{-- Email --}}
                  <div class="form-group">
                      <label for="email">Email:</label>
                    <input 
                      type="email"
                      name="email"
                      value="{{ old('email') }}"
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
                        placeholder="At least 8 characters"
                      >
                    </div>

                    <div class="form-group">
                      <input type="checkbox" id="showPasswordCheckbox">
                      <label>Show Password</label>
                    </div>

                    <input type="submit" class="btn mt-4 reg_btn text-light" value="Log In">
                    
                    <a href="{{ route('rapha.signup') }}" class="url">Don't have an account? Sign up</a>
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