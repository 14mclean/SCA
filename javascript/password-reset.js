const password_inputs = document.querySelectorAll("input[\"type=password\"]");
const visibility_eyes = document.querySelectorAll(".visibility-eye");


password_inputs.forEach((input) => {
    input.addEventListener("input", matching_passwords)
});

function matching_passwords() {
    if(password_inputs[0].value == "") return; // clear validation?
    if(password_inputs[1].value == "") return;

    if(password_inputs[0].value == password_inputs[1].value) {
        password_inputs[1].setCustomValidity("");
    } else {
        password_inputs[1].setCustomValidity("Passwords do not match");
    }
}


password_inputs[0].addEventListener("keyup", debounce(() => {
    const validity_value = password_validity(password_inputs[0].value);

    password_inputs[0].setCustomValidity(validity_value);
    password_inputs[0].reportValidity();
    return validity_value == "";
}, 1000));


visibility_eyes.forEach((button) => {
    button.addEventListener("click", (event) => {
        const related_input = password_inputs[
            Array.from(visibility_eyes).findIndex(element => element == event.target)
        ];

        if(related_input.type == "password") {
            related_input.type = "text";
            event.target = "assets/openEye.png";
        } else {
            related_input.type = "password";
            event.target = "assets/noEye.png";
        }
    })
});