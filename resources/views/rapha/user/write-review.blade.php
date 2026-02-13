<x-user-layout title="Write a Review">
  <x-slot name="content">
    <div class="row mt-5">
         <form action="{{ route('write-review.store') }}" method="post">
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
           <textarea name="content" id="review-content" class="mx-auto d-block col-12 col-sm-8 col-md-7 text-center mt-4" placeholder="Talk About Your Experience" rows="8" maxlength="250"></textarea>
           <span id="char-count" class="d-block text-center">0/250</span>
           <div class="message text-danger text-center"></div>
        </div>
       
        <input type="submit" id="submit-review-btn" class="btn mt-4 reg_btn text-light col-5 col-sm-3 mx-auto d-block" value="Submit Review">

        <!-- validation errors -->
        @if($errors->any())
          @foreach ($errors->all() as $error)
            <div class="alert alert-danger mt-3">
              {{ $error }}
            </div>
          @endforeach
        @endif
      </form>
    </div>
  </x-slot>
</x-user-layout>