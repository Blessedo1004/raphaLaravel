import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

document.addEventListener('DOMContentLoaded', function() {
    // show and hide passwords
const showPassword = document.querySelector('#showPasswordCheckbox');
const password = document.querySelector('#password');
const passwordConfirm = document.querySelector('#password_confirmation');
let clicked = false;
if (showPassword){
showPassword.addEventListener('click',()=>{
  if (!clicked){
    password.type="text"
    if (passwordConfirm){
    passwordConfirm.type="text"
    }
    clicked=true;
  }
  else if(clicked){
    password.type="password";
    if (passwordConfirm){
    passwordConfirm.type="password"
    }
    clicked=false
  }
})
}

//adds margin top to form groups
window.addEventListener('load', () => {
  document.querySelectorAll('.form-group').forEach(formGroup=>{
    formGroup.classList.add('mt-3')
  })
})

//preloader
window.addEventListener('load', () => {
  setTimeout(()=>{
    document.querySelector('.preloader').style.display="none"
    document.querySelector('.content').style.display="block"
  }, 1500)
})

 // resend code button countdown
    const resendButton = document.querySelector('#resendCodeButton');

    if(resendButton){
      
     function resendCountdown (){
      let resetCountdownValue = Number(document.querySelector('.resend_countdown_value').innerText); 
        resetCountdownValue--
        document.querySelector('.resend_countdown_value').innerText = resetCountdownValue
        if (resetCountdownValue === 0){
           document.querySelector('.resend_countdown').style.display="none"
            resendButton.disabled = false
        }
     }
        setInterval(resendCountdown,1000)
    }

//fade out alerts after 3 seconds
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert-success');
    if (alerts){
    alerts.forEach(alert => {
        alert.classList.add('fade-out');
        alert.addEventListener('animationend', () => {
            alert.classList.add('d-none');
        });
    });
  }
}, 3000);

    // user profile navigation display
    const bars = document.querySelector('.fa-bars');
    const xmark = document.querySelector('.fa-xmark');

if (bars){
bars.addEventListener('click', ()=>{
    const navRow = document.querySelector('.nav-row');
        navRow.classList.add('fade-in');
        navRow.classList.remove('fade-out')
         navRow.style.display = 'flex';
         navRow.addEventListener('animationend', ()=>{
          navRow.style.display = 'flex';
        })
         document.querySelector('.fa-xmark').style.display = 'block';
         document.querySelector('.fa-xmark').style.cursor = 'pointer';
         document.querySelector('.fa-bars').style.display = 'none';
})
}

if (xmark){
xmark.addEventListener('click', ()=>{
    const navRow = document.querySelector('.nav-row');
        navRow.classList.add('fade-out')
        navRow.classList.remove('fade-in')
        navRow.addEventListener('animationend', ()=>{
          navRow.style.display = 'none';
        })
        document.querySelector('.fa-xmark').style.display = 'none';
        document.querySelector('.fa-bars').style.display = 'block';

})
}

// ratings
  const stars = document.querySelectorAll('.star');
      const ratingValue = document.getElementById('rating-value');

      if (stars){
      stars.forEach(star => {
        star.addEventListener('click', () => {
          const value = parseInt(star.dataset.value);
          ratingValue.value = value;
          stars.forEach((s, i) => {
            if (i < value) {
              s.classList.add('selected');
            } else {
              s.classList.remove('selected');
            }
          });
          checkReview();
          checkValues(ratingValue); 
        });
      });
    }

    // check review rating and content before enabling submit button
    function checkReview(){
      const reviewContent = document.getElementById('review-content');
      const minLength = 20;
      const submitButton = document.getElementById('submit-review-btn');
      if(reviewContent && submitButton){
         const currentLength = reviewContent.value.length;
        if (currentLength < minLength || ratingValue.value === '') {
           submitButton.disabled = true;
          }
           else {
            submitButton.disabled = false;
          }
      }
    }

    checkReview();

    // review char count
    function reviewCharCountCheck() {
        const reviewContent = document.getElementById('review-content');
        const charCount = document.getElementById('char-count');
        const submitButton = document.getElementById('submit-review-btn');

        if (reviewContent && charCount && submitButton) {
            charCount.innerText = `${reviewContent.value.length}/250`;

            checkReview();
            reviewContent.addEventListener('keyup', function() {
                const currentLength = reviewContent.value.length;
                const maxLength = 250;
                
                charCount.innerText = `${currentLength}/${maxLength}`;

                if (currentLength >= 240) {
                    charCount.style.color = 'red';
                    document.querySelector('.message').innerText = `${maxLength - currentLength} Characters Left`;
                } else {
                    charCount.style.color = '';
                    document.querySelector('.message').innerText = '';
                }

                if (currentLength >= maxLength) {
                    document.querySelector('.message').innerText = "Maximum Characters Reached.";
                }

                checkReview();
                checkValues(); 
            });
        }
    }

    // ensures user doesn't submit same review again
    function checkValues(ratingValue) {
        const hiddenRating = document.querySelector('#ratingHidden');
        const hiddenContent = document.querySelector('#contentHidden');
        const rating = ratingValue || document.getElementById('rating-value');
        const content = document.querySelector('#review-content');
        const submitButton = document.getElementById('submit-review-btn');

        if (hiddenRating && hiddenContent && rating && content && submitButton) {
            if (hiddenRating.value === rating.value && hiddenContent.value === content.value) {
                submitButton.disabled = true;
            } else {
                if (content.value.length >= 20) {
                    submitButton.disabled = false;
                }
            }
        }
    }

    if (document.getElementById('review-content')) {
        reviewCharCountCheck();
    }

        const hiddenRating = document.querySelector('#ratingHidden');
        if (hiddenRating) {
            const stars = document.querySelectorAll('.star');
            stars.forEach((s, i) => {
                if (i < hiddenRating.value) {
                    s.classList.add('selected');
                }
            });
            checkValues();
        }

        //prevents user from submitting the same user profile detail when editting
        function checkProfileDetails (){
        const hiddenInput = document.querySelector("#inputHidden")
        const editBtn = document.querySelector("#editBtn")
        const input = document.querySelector("#editInput")
        if(hiddenInput && editBtn && input){
        if (hiddenInput.value === input.value){
              editBtn.disabled=true
              document.querySelector('.edit_error_message').innerText= "Please type a different value"
            }
            else{
              editBtn.disabled = false
              document.querySelector('.edit_error_message').innerText= ""
            }
        }
      }
        checkProfileDetails()

        //checks edit profile details input when user types
        const hiddenInput = document.querySelector("#inputHidden")
        const editBtn = document.querySelector("#editBtn")
        const input = document.querySelector("#editInput")
        if(hiddenInput && editBtn && input ){
          
          input.addEventListener('keyup', function(){
            checkProfileDetails()
          })
        }
    
}); // This closes the DOMContentLoaded listener

// Force reload on back/forward navigation to prevent bfcache issues
window.addEventListener('pageshow', function(event) {
  if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
    window.location.reload();
  }
});

      let count = 0
      const broadcastDiv = document.querySelector('.broadcast-div')
        // window.Echo.channel('pending-reservation')
        // .listen('PendingReservationEvent', (e) => { 
        //     console.log(e.message);
        // }) 

        window.Echo.private(`private-pending-reservation.${window.userId}`)
        .listen('PendingReservationEvent', (e) => { 
          count++
            broadcastDiv.innerHTML = `          <div class="col-8 col-md-3 broadcast mx-auto d-block bg-light text-center py-2">
               <h6>${count} ${e.message}</h6> 
          </div>`
        })

        broadcastDiv.addEventListener('click', ()=>{
          fetch('/admin/reservations/pending-broadcast')
          .then(response => response.json())
          .then(data =>{
              const container = document.getElementById('reservations-container');
              if(!container) return;

              const reservations = data.reservations.data;
              const routeName = data.route; // e.g., "admin-pending"
              
              if(reservations.length === 0){
                  container.innerHTML = '<h4 class="text-center mt-4">No reservations found</h4>';
                  return;
              }

              // Group by date
              const grouped = reservations.reduce((groups, res) => {
                  const date = res.created_at.split('T')[0];
                  if (!groups[date]) groups[date] = [];
                  groups[date].push(res);
                  return groups;
              }, {});

              let html = '';
              const today = new Date().toISOString().split('T')[0];
              const yesterday = new Date(Date.now() - 864e5).toISOString().split('T')[0];

              for (const [date, resList] of Object.entries(grouped)) {
                  let dateLabel = '';
                  if(date === today) dateLabel = 'Today';
                  else if(date === yesterday) dateLabel = 'Yesterday';
                  else {
                      const d = new Date(date);
                      dateLabel = d.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
                  }

                  html += `
                    <div class="col-12 col-lg-10 bg-light mt-3 mx-auto d-block">
                        <h3 class="text-center mt-5 date_heading">${dateLabel}</h3>
                  `;

                  resList.forEach(res => {
                      const time = new Date(res.created_at).toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
                      
                      // Construct URL manually based on routeName
                      let url = '';
                      if(routeName === 'admin-pending') url = `/admin/reservations/pending/${res.id}`;
                      else if(routeName === 'admin-active') url = `/admin/reservations/active/${res.id}`;
                      else if(routeName === 'admin-completed') url = `/admin/reservations/completed/${res.id}`;

                      html += `
                        <a href="${url}" class="text-black mx-auto d-block col-11 col-md-8 reservation_div mt-4 py-2 mb-3">
                            <div class="row justify-content-center">
                              <h5 class="col-12 col-sm-6 col-xl-4 text-center text-md-start">${res.user.last_name} ${res.user.first_name}</h5>
                              <h5 class="col-12 col-sm-6 col-xl-4 text-center text-md-start">${res.room.name}</h5>
                            </div>
                            <h6 class="mt-2 text-center">${time}</h6>
                        </a>
                      `;
                  });

                  html += `</div>`;
              }
              
              container.innerHTML = html;
          })
          .catch(error => {
              console.error('Error fetching reservations:', error);
              // Optionally display an error message to the user
              const container = document.getElementById('reservations-container');
              if (container) {
                  container.innerHTML = '<h4 class="text-center mt-4 text-danger">Failed to load reservations. Please try again.</h4>';
              }
          })
          broadcastDiv.innerHTML = ''
          count=0
        })


        
