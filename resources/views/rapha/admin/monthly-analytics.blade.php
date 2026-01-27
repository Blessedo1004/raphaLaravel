<x-user-layout title="Dashboard">

  <x-slot name="content">
    <div class="container mt-5">
      <div class="row">
  
        <h2 class="text-center mt-5"><strong>Monthly Analytics</strong></h2>
         <div class="form-group">
          <div class="year_selection">
              <label for="years"><h5>Year:</h5></label>
              <select id="yearSelect" name="year" class="mt-2">
                  <option value="" selected disabled>Choose a year</option>
                    @foreach ($years as $year)
                      <option value="{{ $year }}" {{ $year == old('year') || ($currentYear && $year == $currentYear) ? 'selected' : '' }}>{{$year}}</option>
                    @endforeach
                </select>
          </div>

        </div>

         <div class="form-group">
          <div class="month_selection">
              <label for="months"><h5>Month:</h5></label>
              <select id="monthSelect" name="month" class="mt-2">
                  <option value="" selected disabled>Choose a month</option>
                  @php
                      $months = [
                         'January', 'February', 'March', 'April',
                         'May', 'June', 'July', 'August',
                         'September', 'October', 'November', 'December'
                      ];
                  @endphp
                  @foreach ($months as $month)
                      <option value="{{ $month }}">{{ $month }}</option>
                  @endforeach
              </select>
          </div>

        </div>

        <form id="roomMonthlyAnalytics" method="post">
          @csrf
          <input type="hidden" name="year" id="year">
          <input type="hidden" name="month" id="month">
          <input type="submit" class="btn reg_btn text-light mx-auto d-block mt-4" value="Fetch Analytics"> 
        </form>

        <form id="roomMonthlyAnalyticsSearch" method="post">
          @csrf
          <input type="hidden" name="year2" id="year2">
          <input type="hidden" name="month2" id="month2">
            <div class="col-11 col-sm-8 mt-4 mx-auto d-block">
              <div class="input-group my-4" id="roomSearch">
                <input 
                type="text" 
                id="roomAnalyticsSearch" 
                name="search" 
                value=""
                class="bg-white form-control"
                placeholder="Type room name..."
              >
              <input type="submit" class="btn reg_btn text-light input-group-text" value="Search">
             </div>
            </div> 
        </form>
        <div class="search_error text-danger text-center"></div>

        <div class="col-12 text-center mt-3" id="analyticsTable"></div>
      </div>
    </div>
  </x-slot>
  
</x-user-layout>

