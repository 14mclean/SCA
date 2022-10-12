const form = document.querySelector(".container form");
const password_input = document.querySelector("input[type=\"password\"]");
const email_input = document.querySelector("input[type=\"email\"]");
form.addEventListener("submit", expert_signup);
password_input.addEventListener("input", password_validate);

function expert_signup(event) {
    event.preventDefault();
    password_input.dispatchEvent(new Event("input"));

    if(password_input.checkValidity() && email_input.checkValidity()) {
        console.log("check for preused email");
    }
}

function password_validate(event) {
    pwd = password_input.value;

    if(pwd.length > 8) {
        password_input.tooShort = true;
    } else if((pwd.match(/[A-Z]/g) || []).length < 1) {
        password_input.setCustomValidity("Password requires at least 1 uppercase character");
    } else if((pwd.match(/[a-z]/g) || []).length < 1) {
        password_input.setCustomValidity("Password requires at least 1 lowercase character");
    } else if((pwd.match(/[0-9]/g) || []).length < 1) {
        password_input.setCustomValidity("Password requires at least 1 numeric character");
    } else {
        password_input.setCustomValidity("");
    }

    password_input.reportValidity();
}