<x-user-layout title="Dashboard">

  <x-slot name="content">
    <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-5 dashboard_item py-3">
        <div class="col-12">
          <h4 class="text-center">Total Pending Reservations:</h4>
        </div>
         <div class="mt-3 total_border mx-auto d-block"></div>
         <h5 class="text-center total">{{$pending}}</h5>
      </div>

      <div class="col-12 col-md-5 dashboard_item py-3 mt-3 mt-md-0 ms-md-3">
        <div class="col-12">
          <h4 class="text-center">Total Active Reservations:</h4>
        </div>
         <div class="mt-3 total_border mx-auto d-block"></div>
         <h5 class="text-center total">{{$active}}</h5>
      </div>
      
      <div class="col-12 col-md-5 dashboard_item py-3 mt-3">
        <div class="col-12">
          <h4 class="text-center">Total Cleared Reservations:</h4>
        </div>
         <div class="mt-3 total_border mx-auto d-block"></div>
         <h5 class="text-center total">{{$cleared}}</h5>
      </div>
    </div>
    </div>
  </x-slot>
  
</x-user-layout>

