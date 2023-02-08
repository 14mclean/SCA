document.querySelector("svg.visiblity-eye").addEventListener("click", swap_visibility);
function swap_visibility(event) {
    const password_input = document.querySelector('#password_input');
    event.currentTarget.classList.toggle("closed");

    if(password_input.type == "password") {
        password_input.type = "text";
    } else {
        password_input.type = "password";
    }
}

function check_credentials(form) {
    const password = document.querySelector('#password_input').value;
    const email = document.querySelector('#email_input').value;

    if(document.querySelector("input#last").value != "") {
        return false;
    }

    fetch("/phpScripts/credentials_check.php", {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({"email":email,"password":password})
    })
    .then(response => {
        switch(response.status) {
            case 200:
                form.submit();
                break;
            case 401:
                return response.text();
                break;
            default:
                throw new Error('Server error ' + response.status);
        }
    })
    .then(content => {
        if(content == "Email not verified") {
            document.querySelector('#unverified-email').style.display = "block";
            document.querySelector('#bad-login').style.display = "none";
        } else if(content == "Invalid") {
            document.querySelector('#bad-login').style.display = "block";
            document.querySelector('#unverified-email').style.display = "none";
        }
    });
}

document.querySelector(".decision-blur").addEventListener("click", decision_visibility);
document.querySelector(".register-button").addEventListener("click", decision_visibility);
function decision_visibility(event) {
    const decision_blur = document.querySelector(".decision-blur");
    
    if(decision_blur.style.display == "block") {
        decision_blur.style.display = "none";
        
    } else {
        decision_blur.style.display = "block";
    }
}