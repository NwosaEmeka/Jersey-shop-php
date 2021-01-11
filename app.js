
// check password and cpassword
let password = document.querySelector("#password");
let cpassword = document.querySelector("#cpassword");
let passError = document.querySelector(".passErr");

cpassword.addEventListener('keyup',()=> {
  if (cpassword.value !== password.value) {
    passError.classList.add('active');
  }
  else {
    passError.classList.remove('active');
  }
})
