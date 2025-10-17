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

        {{-- first name --}}
        <h4 class="text-center d-flex justify-content-center">First Name: &nbsp;{{$profile->first_name}}
           <a href="{{ route('show-edit-first-name') }}">
            <i class="fa-solid fa-user-pen" title="Edit"></i>
          </a> 
          
        </h4>

        {{-- last name --}}
         <h4 class="text-center d-flex justify-content-center mt-3">Last Name: &nbsp;{{$profile->last_name}}
           <a href="{{ route('show-edit-last-name') }}">
            <i class="fa-solid fa-user-pen" title="Edit"></i>
          </a> 
          
        </h4>

        {{-- user name --}}
        <h4 class="text-center mt-4">User Name:&nbsp;{{$profile->user_name}} 
          <a href="{{ route('show-edit-user-name') }}">
            <i class="fa-solid fa-user-pen" title="Edit"></i>
          </a>
        </h4>

        {{-- phone number --}}
        <h4 class="text-center mt-4">Phone Number:&nbsp;{{$profile->phone_number}} 
          <a href="{{ route('show-edit-phone-number')}}">
            <i class="fa-solid fa-user-pen" title="Edit"></i>
          </a>
        </h4>

        {{-- email address --}}
        <h4 class="text-center mt-4">Email Address:&nbsp;{{$profile->email}}</h4>
      </div>
    </div>
  </div> 

</x-slot>  
</x-user-layout>


