const passwordInput = document.querySelector("#passwordObscured");
const eyeIcon = document.querySelector(".eyeIcon");

eyeIcon.addEventListener("click", swapPasswordVisiblity);

function swapPasswordVisiblity() {
    // if password visible
    if(passwordInput.id == "passwordVisible") {
        // set password input to obscured text
        passwordInput.setAttribute('type','password');
        passwordInput.setAttribute('id','passwordObscured');
        // set eye icon to open eye
        eyeIcon.setAttribute('src','../assets/openEye.png');
    }
    // else
    else {
        // set password input to normal text
        passwordInput.setAttribute('type','text');
        passwordInput.setAttribute('id','passwordVisible');
        // set eye icon to noEye
        eyeIcon.setAttribute('src','../assets/noEye.png');
    }
}