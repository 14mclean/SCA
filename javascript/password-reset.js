const password_inputs = document.querySelectorAll("input[type=\"password\"]");
const visibility_eyes = document.querySelectorAll("svg.visibility-eye");

// ensure first password value is a valid password
password_inputs[0].addEventListener("keyup", debounce(() => {
    password_inputs[0].setCustomValidity(password_inputs[0].value);
    password_inputs[0].reportValidity();
}, 1000));

// ensure matching passwords
password_inputs.forEach((input) => { 
    input.addEventListener("click", () => {
        if(password_inputs[0] == "" || password_inputs[1] == "") return;

        if(password_inputs[0].value == password_inputs[1].value) {
            password_inputs[1].setCustomValidity("");
        } else {
            password_inputs[1].setCustomValidity("Passwords do not match");
        }

        password_inputs[1].reportValidity();
    });
});

// swap visiblity of password inputs
visibility_eyes.forEach((eye) => {
    eye.addEventListener("click", (event) => {
        const current_eye = event.target;

        // get associated input for visiblity eye
        const related_input = password_inputs[ Array.from(visibility_eyes).findIndex(element => element == current_eye) ];

        // toggle eye class
        current_eye.classList.toggle("closed");

        // toggle input type
        if(related_input.type == "password") {
            related_input.type = "text";
        } else {
            related_input.type = "password";
        }
    });
});