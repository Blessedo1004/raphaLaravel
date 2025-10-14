<x-user-layout title="Dashboard"></x-user-layout>

@if(session('loginSuccess'))

  <div class="alert alert-success text-center">
       {{session('loginSuccess')}}
  </div>
  
@endif