<x-user-layout title="Client Reviews">

  <x-slot name="content">
    <div class="container mt-2">
      <div class="row">
        <h2 class="text-center mt-5 mb-5"><strong>Client Reviews</strong></h2>


        <form id="client-reviews" method="post">
          @csrf
          <div class="form-group">
            <div class="d-flex justify-content-center gap-3">
              <label for="startingDate"><h5>Starting Date:</h5></label>
              <input type="date" name="startingDate" id="startingDate" class="form-control">
            </div>

          </div>

         <div class="form-group">
              <div class="d-flex justify-content-center mt-4 gap-3">
                  <label for="endingDate"><h5>Ending Date:</h5></label>
                  <input type="date" name="endingDate" id="endingDate" class="form-control">

              </div>

          </div>
          
          <h5 class="text-center mt-4">Filter By:</h5>
          
          <div class="row d-flex justify-content-center">
          <div class="form-group col-12 col-md-2 d-flex justify-content-center">
            <h6>
              <input type="radio" name="rating" value="all" id="all">All
            </h6>
          </div>

           <div class="form-group col-12 col-md-2 d-flex justify-content-center">
            <h6>
              <input type="radio" name="rating" value="1">1 Star Rating
            </h6>
          </div>
          
          <div class="form-group col-12 col-md-2 d-flex justify-content-center">
            <h6>
              <input type="radio" name="rating" value="2">2 Star Rating
            </h6>
          </div>
          
          <div class="form-group col-12 col-md-2 d-flex justify-content-center">
            <h6>
              <input type="radio" name="rating" value="3">3 Star Rating
            </h6>
          </div>
         
          <div class="form-group col-12 col-md-2 d-flex justify-content-center">
            <h6>
              <input type="radio" name="rating" value="4">4 Star Rating
            </h6>
          </div>

          <div class="form-group col-12 col-md-2 d-flex justify-content-center">
            <h6>
              <input type="radio" name="rating" value="5">5 Star Rating
            </h6>
          </div>
          </div>

          <input type="submit" class="btn reg_btn text-light mx-auto d-block mt-4" value="Filter" id="filterClientReviews"> 
        </form>
      </div>

        <h4 class="text-center mt-5 reviews-total"></h4>
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

      <div id="pagination-container" class="d-flex justify-content-center mt-4">
          {{ $reviews->links() }}
      </div>

    </div>
  </x-slot>
  
</x-user-layout>

