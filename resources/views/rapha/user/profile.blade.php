<x-user-layout title="Profile">
  <x-slot name="content">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-12">
        @if(session('editSuccess'))
          <div class="alert alert-success text-center">
          {{session('editSuccess')}}
        </div>
        @endif
        <h1 class="text-center mb-4"><strong>User Profile</strong></h1>
        <h4 class="text-center d-flex justify-content-center">First Name: &nbsp;{{$profile->first_name}}
           <a href="{{ route('show-edit-first-name') }}"><i class="fa-solid fa-user-pen" title="Edit"></i></a> 
          
        </h4>

         <h4 class="text-center d-flex justify-content-center mt-3">Last Name: &nbsp;{{$profile->last_name}}
           <a href="{{ route('show-edit-last-name') }}"><i class="fa-solid fa-user-pen" title="Edit"></i></a> 
          
        </h4>

        {{-- 

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

</x-slot>  
</x-user-layout>

   {{-- <div class="modal_container">
      <div class="modal_body">
        <span class="text-end">
          <i class="fa-solid fa-xmark closeBtn" title="close"></i>
        </span> --}}
         
        {{-- <h3>{{$header}}</h3> --}}
       

         {{-- <form action="{{ route($route,$profile->$wildcard) }}" method="post" class="mt-4">
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
        </form> --}}
      {{-- </div>
    </div> --}}

