



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
                   <form wire:submit="signup" class="mt-5">
                    @csrf

                    <h1 class="mt-4">Sign Up</h1>
                    {{-- First Name --}}
                    <div class="form-group mt-3">
                      <label for="first_name">First Name:</label>
                    <input 
                      type="text"
                      wire:model.live.debounce.500ms="first_name"
                      required
                      class="bg-white form-control @error('first_name') is-invalid @enderror"
                    >
                    @error('first_name')
                      <div class="invalid-feedback mt-1 ">{{ $message }}</div>
                    @enderror
                    </div>
                    
                    {{-- Last name --}}
                    <div class="form-group mt-3">
                      <label for="last_name">Last Name:</label>
                    <input 
                      type="text"
                      wire:model.live.debounce.500ms="last_name"
                      required
                      class="bg-white form-control @error ('last_name') is-invalid @enderror"
                    >
                    @error('last_name')
                      <div class="invalid-feedback mt-1 ">{{ $message }}</div>
                    @enderror
                    </div>

                    {{-- Username --}}
                    <div class="form-group mt-3">
                      <label for="username">Username:</label>
                    <input 
                      type="text"
                      wire:model.live.debounce.500ms="user_name"
                      required
                      class="bg-white form-control @error('user_name') is-invalid @enderror"
                    >
                    @error('user_name')
                      <div class="invalid-feedback mt-1 ">{{ $message }}</div>
                    @enderror
                    </div>

                    {{-- Phone Number --}}
                    <div class="form-group mt-3">
                      <label for="phone_number">Phone Number:</label>
                    <input 
                      type="number"
                      wire:model.live.debounce.500ms="phone_number"
                      required
                      class="bg-white form-control @error('phone_number') is-invalid @enderror"
                      placeholder="e.g 09012345678"
                    >
                    @error('phone_number')
                      <div class="invalid-feedback mt-1 ">{{ $message }}</div>
                    @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-group mt-3">
                      <label for="email">Email:</label>
                    <input 
                      type="email"
                      wire:model.live.debounce.500ms="email"
                      required
                      class="bg-white form-control @error('email') is-invalid @enderror"
                    >
                    @error('email')
                      <div class="invalid-feedback mt-1 ">{{ $message }}</div>
                    @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-group mt-3">
                      <label for="password">Password:</label>
                      <h6 class="col-10"> Use a minimum of 8 characters, with at least one uppercase and lowercase letter, number and special character.</h6>
                      <input 
                        type="password"
                        wire:model.live.debounce.500ms="password"
                        id="password"
                        required
                        class="bg-white form-control @error('password') is-invalid @enderror mt-4"
                        placeholder="Enter Password"
                      >
                      @error('password')
                        <div class="invalid-feedback mt-1"><h6 class="col-9">{{ $message }}</h6></div>
                      @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="form-group mt-3">
                      <label for="password_confirmation">Confirm Password:</label>
                      <input 
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        wire:model.live.debounce.500ms="password_confirmation"
                        required
                        class="bg-white form-control @error('password_confirmation') is-invalid @enderror"
                        placeholder="Confirm Password"
                      >
                      @error('password_confirmation')
                        <div class="invalid-feedback mt-1">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="form-group">
                      <input type="checkbox" id="showPasswordCheckbox">
                      <label>Show Password</label>
                    </div>

                     <div class="col-12">
                          <button type="submit" class="btn mt-4 reg_btn text-light col-7 col-md-6 col-lg-9"> Sign Up</button>
                     </div>
                    
                     <div class="col-8 col-sm-7 col-md-6 col-lg-9 mt-3 text-center mb-4">
                          <a href="{{ route('rapha.login') }}" class="url">Already signed up? Log In</a>
                    </div>
                  </form> 
                  {{-- Form ends --}}
            
            </div>
      

          </div>
        </div>
    </div>
  </div>
  {{-- content ends --}}


