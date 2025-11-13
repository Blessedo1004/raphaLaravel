<x-user-layout title="Reviews">
  <x-slot name="content">

         {{-- Review success alert starts --}}
      @if(session('reviewSuccess'))
        <div class="alert alert-success text-center col-md-8 mx-auto d-block mt-4">
          {{session('reviewSuccess')}}
        </div>
      @endif
      {{-- Review success alert ends --}}
      
        {{-- Edit Review success alert starts --}}
      @if(session('editReviewSuccess'))
        <div class="alert alert-success text-center col-md-8 mx-auto d-block mt-4">
          {{session('editReviewSuccess')}}
        </div>
      @endif
      {{-- Edit Review success alert ends --}}

      {{-- Delete Review success alert starts --}}
      @if(session('deleteReviewSuccess'))
        <div class="alert alert-success text-center col-md-8 mx-auto d-block mt-4">
          {{session('deleteReviewSuccess')}}
        </div>
      @endif
      {{-- Delete Review success alert ends --}}



     @if($reviews->isEmpty())

      <h4 class="text-center mt-5">No reviews yet</h4>

      @else

      <h2 class="text-center mt-5"><strong>Your Reviews</strong></h2>
      @foreach ($reviews as $review )
      <div class="review_container mt-4">
        <div class="review_actions action_{{ $review->id }}">
          <div class="text-center">
           <a href="{{ route('show-edit-review', $review->id) }}" class="url"><h6>Edit Review</h6></a>
        </div>
        <div class="text-center">
          <a href="{{ route('show-delete-review', $review->id) }}" class="text-danger"><h6>Delete Review</h6></a>
        </div>
        </div>

          <div class="row justify-content-center align-items-center">
            <div class="col-6 col-sm-3 col-md-2">
              <img src="{{ asset('images/' . $review->rating->rating_photo ) }}" alt="rating" class="reviews-rating">
            </div>
        
            <div class="col-2 col-sm-1">
          
              <img src="{{ asset('images/dots.png') }}" alt="review_action_toggle" data-id="{{ $review->id }}" id="review_action_toggle">
         
            </div>
          </div>
      
      
        <h3 class="mb-4 fadeInUp col-11 col-md-9 mx-auto d-block text-center mt-3 mt-md-0">{{$review->content}}</h3>

        
        
      </div>
      @endforeach
    @endif

    @if (session('deleteReviewModal'))
      <x-reservation-modal>
        <x-slot name="modalContent">
          <h4 class="text-danger"> Are you sure you want to delete your review? This can't be undone!!</h4>
          <!-- Modal footer -->
          <div class="modal-footer mt-4">
            <button type="button" class="btn reg_btn text-white" id="reservationModalClose" title="close">No</button>
            <form action="{{ route('delete-review', $selectedReview->id) }}" method="post">
              @csrf
              @method('delete')
              <input type="submit" value="Delete Review!" class="btn btn-danger" title="Delete Review">
            </form>
          </div>
        </x-slot>   
      </x-reservation-modal>
    @endif
    
  </x-slot>
</x-user-layout>