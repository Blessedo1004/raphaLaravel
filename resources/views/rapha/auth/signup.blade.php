
<x-head-two title="Sign Up" description="Sign Up at Rapha Hotel to make reservations and more">

<x-slot name="body">
  <!-- page preloader begin -->
        <x-preloader></x-preloader>
        <!-- page preloader close -->
    {{-- content starts --}}
    <div class="content animate__animated animate__fadeIn">
      <div class="container-fluid p-0 details">
        <div class="row g-0">
          <div class="col-12 col-lg-6 img_col">
            <img src="{{ asset('images/gallery/F6.webp') }}" alt="img" class="img-fluid display_img">
          </div>
          <div class="col-12 col-lg-6 form_section">
            <div class="row mt-5 offset-lg-2 mb-5">
      
                 <a href="{{ route('rapha.home') }}" class="url mt-5 mt-lg-0">Back To Home</a>
                 {{-- Form starts --}}
                   <form action="{{ route('rapha.signup') }}" method="POST" class="mt-5">
                    @csrf

                    <h1 class="mt-4">Sign Up</h1>
                    {{-- First Name --}}
                    <div class="form-group">
                      <label for="first_name">First Name:</label>
                    <input 
                      type="text"
                      name="first_name"
                      value="{{ old('first_name') }}"
                      required
                      class="bg-white form-control @error('first_name') is-invalid @enderror"
                    >
                    @error('first_name')
                      <div class="invalid-feedback mt-1 ">{{ $message }}</div>
                    @enderror
                    </div>
                    
                    {{-- Last name --}}
                    <div class="form-group">
                      <label for="last_name">Last Name:</label>
                    <input 
                      type="text"
                      name="last_name"
                      value="{{ old('last_name') }}"
                      required
                      class="bg-white form-control @error ('last_name') is-invalid @enderror"
                    >
                    @error('last_name')
                      <div class="invalid-feedback mt-1 ">{{ $message }}</div>
                    @enderror
                    </div>

                    {{-- Username --}}
                    <div class="form-group">
                      <label for="username">Username:</label>
                    <input 
                      type="text"
                      name="user_name"
                      value="{{ old('user_name') }}"
                      required
                      class="bg-white form-control @error('user_name') is-invalid @enderror"
                    >
                    @error('user_name')
                      <div class="invalid-feedback mt-1 ">{{ $message }}</div>
                    @enderror
                    </div>

                    {{-- Phone Number --}}
                    <div class="form-group">
                      <label for="phone_number">Phone Number:</label>
                    <input 
                      type="number"
                      name="phone_number"
                      value="{{ old('phone_number') }}"
                      required
                      class="bg-white form-control @error('phone_number') is-invalid @enderror"
                      placeholder="e.g 09012345678"
                    >
                    @error('phone_number')
                      <div class="invalid-feedback mt-1 ">{{ $message }}</div>
                    @enderror
                    </div>

                    {{-- Email --}}
                  <div class="form-group">
                      <label for="email">Email:</label>
                    <input 
                      type="email"
                      name="email"
                      value="{{ old('email') }}"
                      required
                      class="bg-white form-control @error('email') is-invalid @enderror"
                    >
                    @error('email')
                      <div class="invalid-feedback mt-1 ">{{ $message }}</div>
                    @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                      <label for="password">Password:</label>
                      <input 
                        type="password"
                        name="password"
                        id="password"
                        required
                        class="bg-white form-control @error('password') is-invalid @enderror"
                        placeholder="At least 8 characters"
                      >
                      @error('password')
                        <div class="invalid-feedback mt-1 ">{{ $message }}</div>
                      @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="form-group">
                      <label for="password_confirmation">Confirm Password:</label>
                      <input 
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        required
                        class="bg-white form-control @error('password_confirmation') is-invalid @enderror"
                      >
                      @error('password_confirmation')
                        <div class="invalid-feedback mt-1 ">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group">
                      <input type="checkbox" id="showPasswordCheckbox">
                      <label>Show Password</label>
                    </div>

                     <div class="col-12">
                          <input type="submit" class="btn mt-4 reg_btn text-light col-7 col-md-6 col-lg-9" value="Sign Up">
                     </div>
                    
                     <div class="col-12 col-lg-10 mt-3 text-lg-center mb-4">
                          <a href="{{ route('rapha.login') }}" class="url">Already signed up? Log In</a>
                    </div>
                  {{-- Form ends --}}
            
            </div>
      

          </div>
        </div>
    </div>
  {{-- content ends --}}
    </div>
    

  
  </x-slot>
</x-head-two>