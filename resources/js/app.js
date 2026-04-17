import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

document.addEventListener('DOMContentLoaded', function() {

function initUI() {

    // SHOW / HIDE PASSWORD
    const showPassword = document.querySelector('#showPasswordCheckbox');
    const password = document.querySelector('#password');
    const passwordConfirm = document.querySelector('#password_confirmation');

    if (showPassword && password) {

        // prevent duplicate listeners
        if (!showPassword.dataset.bound) {
            showPassword.addEventListener('click', () => {
                const isPassword = password.type === "password";

                password.type = isPassword ? "text" : "password";

                if (passwordConfirm) {
                    passwordConfirm.type = isPassword ? "text" : "password";
                }
            });

            showPassword.dataset.bound = "true";
        }
    }

    // PRELOADER
    const preloader = document.querySelector('.preloader');

    if (preloader) {
        setTimeout(() => {
            preloader.style.display = "none";
        }, 1500);
    }
}

window.addEventListener('load', initUI);

//Livewire navigation
document.addEventListener('livewire:navigated', initUI);

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

    // navigation display on smaller screens
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

    //enable resend button after 60secs
    const resendButton = document.querySelector('#resendCodeButton');
    const resendCountDownSpan = document.querySelector('.resend_countdown');
    const resetCountDown = document.querySelector('.resend_countdown_value');

    if (resendButton && resendCountDownSpan && resetCountDown) {
    let resendCountDownValue = document.querySelector('.resend_countdown_value').innerText;
    let resendInterval = setInterval(()=>{
        resendCountDownValue--
        resetCountDown.innerText = resendCountDownValue

        if(resendCountDownValue === 0){
            resendCountDownSpan.style.display = 'none';
            resendButton.disabled=false;
            clearInterval(resendInterval)
        }
    }, 1000)
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
    


// Force reload on back/forward navigation to prevent bfcache issues
window.addEventListener('pageshow', function(event) {
  if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
    window.location.reload();
  }
});

}); // This closes the DOMContentLoaded listener        
