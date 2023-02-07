<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign Up - SCA</title>
        <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
        <link rel="stylesheet" href="css/register.css">
    </head>

    <body>
        <header>
            <a class="back_arrow" href="javascript:history.back()">🠔</a>
            <h1><a href="/">School Citizen Assemblies</a></h1>
        </header>

        <main>
            <div class="form_container">
                <h1>Sign Up</h1>
                <hr />
                <h2><?php echo $_GET["level"]?></h2>

                <form>
                    <input id="email_input" name="email" type="email" autocomplete="email" placeholder="E-mail" required oninput="clear_validation(this)">

                    <input id="password_input" name="password" type="password" autocomplete="new-password" placeholder="Password" required oninput="clear_validation(this)">
                    <svg class="visiblity-eye closed" width="20px" height="20px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path/>
                    </svg>

                    <input type="text" style="display: none;">

                    <?php
                        if($_GET["level"] == "Teacher") {
                            echo("<a class='switch-level-button' href='register.php?level=Expert'>An Expert?</a>");
                        } else {
                            echo("<a class='switch-level-button' href='register.php?level=Teacher'>A Teacher?</a>");
                        }
                    ?>

                    <button>Register</button>
                </form>
            </div>
        </main>
    </body>

    <script src="javascript/valid_password.js"></script>
    <script>
        function clear_validation(element) {
            element.setCustomValidity("");
            element.reportValidity();
        }

        function debounce(callback, wait) {
            let timeout;
            return (...args) => {
                clearTimeout(timeout);
                timeout = setTimeout(function () { callback.apply(this, args); }, wait);
            };
        }

        document.querySelector("#password_input").addEventListener("keyup", debounce(() => { // validate password 1s after typing concludes
            const password_input = document.querySelector("#password_input");
            const validity_value = password_validity(password_input.value);

            password_input.setCustomValidity(validity_value);
            password_input.reportValidity();
            return validity_value == "";

        }, 1000));

        document.querySelector("svg.visibility-eye").addEventListener("click", (event) => { // show/hide password visibility
            const password_input = document.querySelector('#password_input');
            event.target.classList.toggle("closed");

            if(password_input.type == "password") {
                password_input.type = "text";
            } else {
                password_input.type = "password";
            }
        });

        document.querySelector("form").addEventListener("submit", (event) => { // submit form details
            event.preventDefault();
            const email_input = document.querySelector("#email_input");
            const email = email_input.value;

            //fetch("/api/users?email="+email) // get any users with this email
            fetch("/api/users?filter=" + btoa(JSON.stringify({"email":{"operator":"", "value": [email]}})))
            .then((response) => {
                if(response.ok) {
                    return response.json();
                } else {
                    throw new Error('Server error ' + response.status);
                }
            })
            .then(json => {
                if(json.length > 0) { // if json has contents
                    email_input.setCustomValidity("Email already taken");
                    email_input.reportValidity();
                    return false; // fail
                }

                fetch("/api/users", { // POST new user information
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                        "email": email,
                        "password": password_input.value,
                        "email_verified": 0,
                        "user_level": "<?php echo($_GET["level"]) ?>"
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
                    fetch("phpScripts/send_validation_email.php", {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({
                            "email": email,
                            "user_id": json["id"]
                        })
                    })
                    .then(response => {
                        if(!response.ok) {
                            throw new Error('Server error ' + response.status);
                        }
                    });

                    if("<?php echo($_GET["level"]) ?>" == "Expert") { // check if expert
                        fetch("/api/experts", { // POST new expert information
                        method: 'POST',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({
                            "user_id": json["id"]
                        })
                        })
                        .then((response) => {
                            if(!response.ok) {
                                throw new Error('Server error ' + response.status);
                            }
                        });
                    } 
                    
                    window.location.href="post-registration.html";
                });
            });
        });
    </script>
</html>