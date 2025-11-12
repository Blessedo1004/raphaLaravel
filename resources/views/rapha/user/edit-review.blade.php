<x-head-two title="Edit Review" description="zzzzzz">
  <x-slot name="body">
    <x-preloader></x-preloader>
    <div class="content animate__animated animate__fadeIn">
    <div class="notice_container">
      <a href="{{ route('rapha.home') }}">
        <img class="logo-main mx-auto d-block mx-sm-0" src="{{asset('images/logo-white1.webp')}}" alt="logo" >
      </a>  
      <form action="{{ route('edit-review',$review->id) }}" method="post">
        @csrf
        @method('put')
        <h3 class="text-center mt-2">Select a Rating:</h3>
        <div class="rating text d-flex justify-content-center ">
          <span class="star" data-value="1">&#9733;</span>
          <span class="star" data-value="2">&#9733;</span>
          <span class="star" data-value="3">&#9733;</span>
          <span class="star" data-value="4">&#9733;</span>
          <span class="star" data-value="5">&#9733;</span>
        </div>
        <input type="hidden" name="" id="ratingHidden" value="{{ old('content',$review->rating_id) }}">
        <input type="hidden" name="" id="contentHidden" value="{{ old('content',$review->content) }}">
        <input type="hidden" name="rating_id" id="rating-value" value="{{ old('content',$review->rating_id) }}">
        <div>
           <textarea name="content" id="review-content" class="mx-auto d-block col-12 text-center mt-4" placeholder="Talk About Your Experience" rows="8" maxlength="250">{{old('content',$review->content)}}</textarea>
           <span id="char-count" class="d-block text-center">0/250</span>
           <div class="message text-danger text-center"></div>
        </div>
       
        <input type="submit" id="submit-review-btn" class="btn mt-4 reg_btn text-light col-10 mx-auto d-block" value="Submit Review">

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
     </div>
  </x-slot>
</x-head-two>    