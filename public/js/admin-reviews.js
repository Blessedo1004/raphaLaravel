const filterClientReviews = document.querySelector('#filterClientReviews')
const all = document.querySelector('#all')
const clientReviewsForm = document.querySelector('#client-reviews')
const reviewDiv = document.querySelector('#reviews')

all.checked = true
  if (yearSelect2 && yearSelect2.value) {
      hiddenYear.value = yearSelect2.value;
      checkFilterData()
    }
        
    if(yearSelect2){
    yearSelect2.addEventListener('change', ()=>{
        hiddenYear.value = yearSelect2.value;
        checkFilterData()
    })
}

    if(monthSelect && hiddenMonth){
        monthSelect.addEventListener('change', ()=>{
        hiddenMonth.value = monthSelect.value;
        checkFilterData()
    })
    }

if(filterClientReviews){
  filterClientReviews.disabled = true
  // filterClientReviews.addEventListener()

}

function checkFilterData (){
     if (hiddenYear.value.length > 0 && hiddenMonth.value.length > 0){
        filterClientReviews.disabled = false
    }
    else{
        filterClientReviews.disabled = true
    }
}

if(clientReviewsForm){
  clientReviewsForm.addEventListener('submit', function(e){
    e.preventDefault();
    const formData = new FormData(this)
    fetch('/admin/client-reviews',{
      method:'POST',
      body:formData,
      headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    })
    .then(response => response.json())
    .then(data => {
    if (reviewDiv) {
    if (data && data.length > 0) {
        let reviewHtml = '';
        data.forEach(review => {
            const ratingPhoto = review.rating?.rating_photo || 'default.webp';
            const imagePath = `/images/${ratingPhoto}`;            
            reviewHtml += `
                <div class="review_container mt-5 bg-light col-12 col-xl-9 mx-auto d-block">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-6 col-sm-3 col-md-2">
                            <img src="${imagePath}" alt="rating" class="reviews-rating">
                        </div>
                    </div>
                    <h4 class="mb-4 fadeInUp col-11 col-md-9 mx-auto d-block text-center mt-3">${review.content}</h4>
                </div>
            `;
        });
        reviewDiv.innerHTML = reviewHtml;
    } else {
        // Display a message if no reviews are found
        reviewDiv.innerHTML = '<h5 class="text-center mt-5">No reviews found for the selected criteria.</h5>';
    }
}
    })
    .catch(error =>{
       console.error('Error fetching filtered data:', error);
       reviewDiv.innerText = `Couldn't fetch filtered data.`;
    })
  })
}