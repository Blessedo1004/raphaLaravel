<x-user-layout title="Client Reviews">

  <x-slot name="content">
    <div class="container mt-2">
      <div class="row">
        <h2 class="text-center mt-5"><strong>All Reviews</strong></h2>
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
                      1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                      5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                      9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                  ]; 
                  @endphp
                  @foreach ($months as $num =>$month)
                      <option value="{{ $num }}">{{ $month }}</option>
                  @endforeach
              </select>
          </div>

        </div>

        <form id="client-reviews" method="post">
          @csrf
          <input type="hidden" name="year" id="year">
          <input type="hidden" name="month" id="month">
          <h5 class="text-center mt-4">Filter By:</h5>
          
          <div class="row d-flex justify-content-center">
          <div class="form-group col-12 col-md-2 d-flex justify-content-center">
            <h6><input type="radio" name="rating" value="all" id="all">All</h6>
          </div>

           <div class="form-group col-12 col-md-2 d-flex justify-content-center">
          <h6>  <input type="radio" name="rating" value="1">1 Star Rating</h6>
          </div>
          
          <div class="form-group col-12 col-md-2 d-flex justify-content-center">
          <h6>  <input type="radio" name="rating" value="2">2 Star Rating</h6>
          </div>
          
          <div class="form-group col-12 col-md-2 d-flex justify-content-center">
          <h6>  <input type="radio" name="rating" value="3">3 Star Rating</h6>
          </div>
         
          <div class="form-group col-12 col-md-2 d-flex justify-content-center">
          <h6>  <input type="radio" name="rating" value="4">4 Star Rating</h6>
          </div>

          <div class="form-group col-12 col-md-2 d-flex justify-content-center">
          <h6>  <input type="radio" name="rating" value="5">5 Star Rating</h6>
          </div>
          </div>

          <input type="submit" class="btn reg_btn text-light mx-auto d-block mt-4" value="Filter" id="filterClientReviews"> 
        </form>
      </div>

      <div id="reviews">
        @foreach ($reviews as $review )
          <div class="review_container mt-5 bg-light col-12 col-xl-9 mx-auto d-block">
              <div class="row justify-content-center align-items-center">
                <div class="col-6 col-sm-3 col-md-2">
                  <img src="{{ asset('images/' . $review->rating->rating_photo ) }}" alt="rating" class="reviews-rating">
                </div>
              </div>
          
            <h4 class="mb-4 fadeInUp col-11 col-md-9 mx-auto d-block text-center mt-3">{{$review->content}}</h4>
          </div>
        @endforeach
      </div>

    </div>
  </x-slot>
  
</x-user-layout>

