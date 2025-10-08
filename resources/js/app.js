// import './bootstrap';

const showPassword = document.querySelector('#showPasswordCheckbox');
const password = document.querySelector('#password');
const passwordConfirm = document.querySelector('#password_confirmation');
let clicked = false;
if (showPassword){
showPassword.addEventListener('click',()=>{
  if (!clicked){
    password.type="text"
    passwordConfirm.type="text"
    clicked=true;
  }
  else if(clicked){
    password.type="password";
    passwordConfirm.type="password"
    clicked=false
  }
})
}