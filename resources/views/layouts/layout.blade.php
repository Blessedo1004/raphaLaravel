<x-user-layout title="Reservations">
  <x-slot name="content">
    <div class="container mt-5">
        <div class="col-9 mx-auto d-block">
          @if(session('checkinSuccess'))
            <div class="alert alert-success text-center col-md-8 mx-auto d-block">
              {{session('checkinSuccess')}}
           </div>
          @endif
        </div>

       @if(session('checkoutSuccess'))
        <div class="alert alert-success text-center col-md-8 mx-auto d-block">
          {{session('checkoutSuccess')}}
        </div>
      @endif
      
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 reservation_col">
          <div class="row justify-content-center">
            <a href="{{ route('admin-reservations' ) }}" @class(['py-3 col-5 col-sm-4 btn reservation_nav', 'active2' => request()->routeIs('admin-reservations')]) wire:navigate>
             Pending
            </a>
              
            <a href="{{ route('admin-active-reservations' ) }}" @class(['py-3 col-5 col-sm-4 btn reservation_nav', 'active2' => request()->routeIs('admin-active-reservations')]) wire:navigate>
             Active
            </a>

            <a href="{{ route('admin-completed-reservations' ) }}" @class(['py-3 col-5 col-sm-4 btn reservation_nav', 'active2' => request()->routeIs('admin-completed-reservations')]) wire:navigate>
              Completed
            </a>


            {{ $slot }}
    </x-slot>        
</x-user-layout>            