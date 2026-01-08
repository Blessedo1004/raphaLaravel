<x-user-layout title="Dashboard">

  <x-slot name="content">
    <div class="container mt-5">
    <div class="row justify-content-center dashboard_row">
      <div class="col-12 col-md-4 col-lg-3 dashboard_item py-3">
        <div class="col-12">
          <h4 class="text-center">Total Pending Reservations:</h4>
        </div>
         <div class="mt-3 total_border mx-auto d-block"></div>
         <h5 class="text-center total">{{$pending}}</h5>
      </div>

      <div class="col-12 col-md-4 col-lg-3 dashboard_item py-3 mt-3 mt-md-0">
        <div class="col-12">
          <h4 class="text-center">Total Active Reservations:</h4>
        </div>
         <div class="mt-3 total_border mx-auto d-block"></div>
         <h5 class="text-center total">{{$active}}</h5>
      </div>

      <div class="col-12 col-md-4 col-lg-3 dashboard_item py-3 mt-3 mt-md-0">
        <div class="col-12">
          <h4 class="text-center">Total Completed Reservations:</h4>
        </div>
         <div class="mt-3 total_border mx-auto d-block"></div>
         <h5 class="text-center total">{{$completed}}</h5>
      </div>
    </div>
    </div>

    <div class="container">
      <div class="row">
        <h2 class="text-center mt-5"><strong>Analytics</strong></h2>

        <div class="form-group">
          <div class="year_selection">
              <label for="years"><h5>Year:</h5></label>
              <select id="yearsAdmin" name="year" class="mt-2">
                  <option value="" selected disabled>Choose a year</option>
                    @foreach ($years as $year)
                      <option value="{{ $year }}" {{ $year == old('year') || ($currentYear && $year == $currentYear) ? 'selected' : '' }}>{{$year}}</option>
                    @endforeach
                </select>
          </div>

        </div>

        <div class="col-12 text-center mt-3" id="adminTable"></div>
      </div>
    </div>
  </x-slot>
  
</x-user-layout>

