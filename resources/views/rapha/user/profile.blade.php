<x-user-layout title="Profile">
  <x-slot name="content">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-12">
        @if(session('firstName'))
          <div class="alert alert-success text-center">
          {{session('firstName')}}
        </div>
        @endif
        <h2 class="text-center mb-4">User Profile</h2>
        <h4 class="text-center">First Name: &nbsp; &nbsp;{{$profile->first_name}}
          <button type="button" class="btn">
            <i class="fa-solid fa-user-pen" data-bs-toggle="modal" data-bs-target="#myModal"></i>
          </button>
        </h4>

        {{-- <h4 class="text-center mt-4">Last Name:&nbsp; &nbsp;{{$profile->last_name}} 
        <a href="{{ route('edit-last-name',$profile->last_name) }}">
          <i class="fa-solid fa-user-pen"></i></a></h4>

        <h4 class="text-center mt-4">User Name:&nbsp; &nbsp;{{$profile->user_name}} 
          <a href="{{ route('edit-user-name',$profile->user_name) }}">
            <i class="fa-solid fa-user-pen"></i></a></h4>

        <h4 class="text-center mt-4">Phone Number:&nbsp; &nbsp;{{$profile->phone_number}} 
          <a href="{{ route('edit-phone-name',$profile->phone_number) }}">
            <i class="fa-solid fa-user-pen"></i></a></h4>

        <h4 class="text-center mt-4">Email Address:&nbsp; &nbsp;{{$profile->email}}</h4> --}}
      </div>
    </div>
  </div> 
  
  {{-- modal --}}
  <div class="modal" id="myModal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">{{$header}}</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form action="{{ route($route,$profile->$wildcard) }}" method="post">
          @csrf
          @method('put')
          <div class="form-group">
            <input 
              type="text"
              name="first_name"
              required
              class="bg-white form-control"
              placeholder="{{ $placeholder }}"
            >
           </div>
          <input type="submit" class="btn mt-4 reg_btn text-light col-9" value="Submit">
          <!-- validation errors -->
          @if($errors->any())
            @foreach ($errors->all() as $error)
              <div class="alert alert-danger mt-3 col-12">
                {{ $error }}
              </div>
              
            @endforeach
          @endif
        </form>
      </div>

    </div>
  </div>
</div>
  


</x-slot>  
</x-user-layout>