const form = document.querySelector(".container form");
const password_input = document.querySelector("input[type=\"password\"]");
const email_input = document.querySelector("input[type=\"email\"]");
form.addEventListener("submit", expert_signup);
password_input.addEventListener("input", password_validate);

function expert_signup(event) {
    event.preventDefault();
    password_input.dispatchEvent(new Event("input"));

    if(password_input.checkValidity() && email_input.checkValidity()) {
        fetch("/api/users") // get all users
        .then((response) => {
            if(response.ok) {
                return response.json();
            } else {
                throw new Error('Server error ' + response.status);
            }
        })
        .then(json => {
            for(const record of json) {
                if(record["email"] == email_input.value) { // check if email has been taken
                    email_input.setCustomValidity("Email has already been used");
                    email_input.reportValidity();
                    return
                }
            }

            fetch("/api/users", { // POST new user information
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                        "email": email_input.value,
                        "password": password_input.value,
                        "emailVerified": 0,
                        "userLevel": "Expert"
                    })
            })
            .then((response) => {
                if(response.ok) {
                    return response.json();
                } else {
                    throw new Error('Server error ' + response.status);
                }
            })
            .then(json => {
                fetch("/api/experts", { // POST new expert information
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        "userID": json["id"]
                    })
                })
                .then((response) => {
                    if(!response.ok) {
                        throw new Error('Server error ' + response.status);
                    }
                });
            })
        });
    }
}

function password_validate(event) {
    pwd = password_input.value;

    if(pwd.length < 8) {
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