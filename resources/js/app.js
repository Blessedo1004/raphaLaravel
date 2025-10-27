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
        navRow.style.display = 'flex';
        navRow.classList.add('fade-in');
         document.querySelector('.content-div').style.marginTop = '10%';
         document.querySelector('.fa-xmark').style.display = 'block';
         document.querySelector('.fa-xmark').style.cursor = 'pointer';
         document.querySelector('.fa-bars').style.display = 'none';
})
}

if (xmark){
xmark.addEventListener('click', ()=>{
    const navRow = document.querySelector('.nav-row');
        navRow.classList.add('fade-out');
        navRow.style.display = 'none';
        document.querySelector('.content-div').style.marginTop = '0';
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
        });
      });
    }

    // Review character counter and button disabler
    const reviewContent = document.getElementById('review-content');
    const charCount = document.getElementById('char-count');
    charCount.innerText = `${reviewContent.value.length}/250`
    const submitButton = document.getElementById('submit-review-btn');
     if (reviewContent.value.length < 20) {
                submitButton.disabled = true;
            }
    if (reviewContent && charCount && submitButton) {
        reviewContent.addEventListener('keyup', function() {
            const currentLength = reviewContent.value.length;
            const maxLength = 250;
            const minLength = 20;

            charCount.innerText = `${currentLength}/${maxLength}`;

            if (currentLength >= 240) {
                charCount.style.color = 'red';
                document.querySelector('.message').innerText = `${maxLength - currentLength} Characters Left`
            } else {
                charCount.style.color = '';
                document.querySelector('.message').innerText = ''
            }

            if (currentLength < minLength) {
                submitButton.disabled = true;
            }
            else {
                submitButton.disabled = false;
            }

            if(currentLength >= maxLength){
              document.querySelector('.message').innerText = "Maximum Characters Reached."
            }
        });
    }
}); // This closes the DOMContentLoaded listener

// Force reload on back/forward navigation to prevent bfcache issues
window.addEventListener('pageshow', function(event) {
  if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
    window.location.reload();
  }
});
