const password_inputs = document.querySelectorAll("input[type=\"password\"]");
const visibility_eyes = document.querySelectorAll("svg.visiblity-eye");
const reset_button = document.querySelector("form button");
const user_id = document.querySelector("form").id;

// ensure first password value is a valid password
password_inputs[0].addEventListener("keyup", debounce(() => {
    password_inputs[0].setCustomValidity(password_validity(password_inputs[0].value));
    password_inputs[0].reportValidity();
}, 1000));

// ensure matching passwords
password_inputs.forEach((input) => { 
    input.addEventListener("click", () => {
        if(password_inputs[0].value == "" || password_inputs[1].value == "") return;

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

reset_button.addEventListener("click", (event) => {
    event.preventDefault();

    const first_value = password_inputs[0].value;
    const second_value = password_inputs[1].value;

    // p0 not valid, set validity
    const first_input_validity = password_validity(first_value);
    if(first_input_validity != "") {
        password_inputs[0].setCustomValidity(first_input_validity);
        password_inputs[0].reportValidity();
        return
    }

    // p1 not same, set validity
    if(first_value != second_value) {
        password_inputs[1].setCustomValidity("Passwords do not match");
        password_inputs[1].reportValidity();
        return;
    }

    // send form to php scripts password reset
    fetch("/api/users/"+user_id, {
        method: "PATCH",
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            "password": first_value
        })
    });

    // foward to main page
    window.location.href = "index.php";
});