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
            <h1><a href="home.php">School Citizen Assemblies</a></h1>
        </header>

        <main>
            <div class="form_container">
                <h1>Sign Up</h1>
                <hr />
                <h2><?php echo $_GET["level"]?></h2>

                <form>
                    <input id="email_input" name="email" type="email" autocomplete="email" placeholder="E-mail" required oninput="clear_validation(this)">

                    <input id="password_input" name="password" type="password" autocomplete="new-password" placeholder="Password" required oninput="clear_validation(this)">
                    <img id="visibility-eye" src="assets/noEye.png">

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
            const password_value = password_input.value;
            let validity_value = "";

            // 8 or more chars
            if(password_value.length < 8) {
                validity_value = "Password must be at least 8 characters long";
            }

            // 1 or more uppercase
            if(password_value.toLowerCase() == password_value) {
                validity_value = "Password requires at least 1 uppercase character";
            }

            // 1 or more lowercase
            if(password_value.toUpperCase() == password_value) {
                validity_value = "Password requires at least 1 lowercase character";
            }

            // 1 or more numeric
            if(!/\d/.test(password_value)) {
                validity_value = "Password requires at least 1 numeric character";
            }

            password_input.setCustomValidity(validity_value);
            password_input.reportValidity();
            return validity_value == "";

        }, 1000));

        document.querySelector("#visibility-eye").addEventListener("click", (event) => { // show/hide password visibility
            const password_input = document.querySelector('#password_input');

            if(password_input.type == "password") {
                password_input.type = "text";
                event.target.src = "assets/openEye.png";
            } else {
                password_input.type = "password";
                event.target.src = "assets/noEye.png";
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