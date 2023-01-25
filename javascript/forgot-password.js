const form = document.querySelector("form");
const email_input = document.querySelector("input#email_input");

form.addEventListener("submit", (event) => {
    event.preventDefault();

    fetch("/api/users?filter=" + btoa(JSON.stringify({"email":{"operator":"", "value": [email_input.value]}})))
    .then(response => {
        if(response.ok) {
            return response.json();
        } else {
            throw new Error('Server error ' + response.status);
        }
    })
    .then(json => {
        if(json.length > 0) {
            fetch("phpScripts/send_password_reset_email.php", {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({"email": email_input.value})
            });

            window.location.href="index.php";
        } else {
            email_input.setCustomValidity("No matching email address");
            email_input.reportValidity();
        }
    });
});