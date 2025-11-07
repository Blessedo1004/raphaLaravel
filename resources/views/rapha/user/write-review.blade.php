<x-user-layout title="Write a Review">
  <x-slot name="content">
    <div class="row mt-5">
      {{-- Review success alert starts --}}
      @if(session('reviewSuccess'))
        <div class="alert alert-success text-center">
          {{session('reviewSuccess')}}
        </div>
      @endif
      {{-- Review success alert ends --}}
      
        {{-- Edit Review success alert starts --}}
      @if(session('editReviewSuccess'))
        <div class="alert alert-success text-center">
          {{session('editReviewSuccess')}}
        </div>
      @endif
      {{-- Edit Review success alert ends --}}

      {{-- Delete Review success alert starts --}}
      @if(session('deleteReviewSuccess'))
        <div class="alert alert-success text-center">
          {{session('deleteReviewSuccess')}}
        </div>
      @endif
      {{-- Delete Review success alert ends --}}


      @if(is_null($review))
         <form action="{{ route('write-review') }}" method="post">
        @csrf
        <h3 class="text-center">Select a Rating:</h3>
        <div class="rating text d-flex justify-content-center ">
          <span class="star" data-value="1">&#9733;</span>
          <span class="star" data-value="2">&#9733;</span>
          <span class="star" data-value="3">&#9733;</span>
          <span class="star" data-value="4">&#9733;</span>
          <span class="star" data-value="5">&#9733;</span>
        </div>
        <input type="hidden" name="rating_id" id="rating-value">
        <div>
           <textarea name="content" id="review-content" class="mx-auto d-block col-12 col-sm-6 text-center mt-4" placeholder="Talk About Your Experience" rows="8" maxlength="250"></textarea>
           <span id="char-count" class="d-block text-center">0/250</span>
           <div class="message text-danger text-center"></div>
        </div>
       
        <input type="submit" id="submit-review-btn" class="btn mt-4 reg_btn text-light col-10 col-sm-3 mx-auto d-block" value="Submit Review">

        <!-- validation errors -->
        @if($errors->any())
          @foreach ($errors->all() as $error)
            <div class="alert alert-danger mt-3">
              {{ $error }}
            </div>
          @endforeach
        @endif
      </form>

      @else
      <h2 class="text-center"><strong>Your Review</strong></h2>
      <img src="{{ asset('images/' . $review->rating->rating_photo ) }}" alt="rating" class="col-4 col-sm-2 mx-auto d-block mt-2 mt-md-5">
      <h3 class="mb-4 wow fadeInUp fs-36 mt-3 col-12 col-md-11 mx-auto d-block text-center ">{{$review->content}}</h3>
      <div class="col-12 mt-3 text-center">
      <a href="{{ route('show-edit-review') }}" class="url"><h5>Edit Review</h5></a>
      </div>

        <button type="button" class="btn btn-danger col-5 col-sm-4 col-md-2 mx-auto d-block mt-4" data-bs-toggle="modal" data-bs-target="#reviewDeleteModal">
        Delete Review
      </button>

      <x-slot name="deleteReviewForm">
        <form action="{{ route('delete-review', $review->id) }}" method="post">
                @csrf
                @method('delete')
                <input type="submit" value="Delete Review!" class="btn btn-danger">
       </form>
      </x-slot>
      
       @endif
     
    </div>
  </x-slot>
</x-user-layout>