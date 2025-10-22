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
    alerts.forEach(alert => {
        alert.classList.add('fade-out');
        alert.addEventListener('animationend', () => {
            alert.classList.add('d-none');
        });
    });
}, 3000);

// modal for editing user profile
const userPen = document.querySelector('.fa-user-pen');
if (userPen) {
    userPen.addEventListener('click', () => {
        document.querySelector('.modal_container').style.display = "flex";
    });
}


// document.querySelector('.closeBtn').addEventListener('click', ()=>{
//       document.querySelector('.modal_container').style.display="none"
//  })

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
});