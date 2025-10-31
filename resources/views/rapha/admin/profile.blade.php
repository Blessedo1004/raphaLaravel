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
        <h2 class="text-center mb-5"><strong>Admin Profile</strong></h2>

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
        <h4 class="text-center mt-4">Email Address:&nbsp;<span class="email"></span>{{$profile->email}}</h4>

          <a href="{{ route('show-change-password') }}">
            <input type="button" class="btn mt-4 reg_btn text-light col-5 col-md-3 mx-auto d-block mt-5" value="Change Password">
          </a>

          <button type="button" class="btn btn-danger col-5 col-sm-4 col-md-2 mx-auto d-block mt-4" data-bs-toggle="modal" data-bs-target="#accountDeleteModal">
        Delete Account
      </button>

      <x-slot name="deleteAccountForm">
        <form action="{{ route('delete-account', Auth::user()->id) }}" method="post">
                @csrf
                @method('delete')
                <input type="submit" value="Delete Account!" class="btn btn-danger">
       </form>
      </x-slot>
      </div>
    </div>
  </div> 

</x-slot>  
</x-user-layout>


