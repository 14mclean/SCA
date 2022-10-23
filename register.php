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
            <h1><a href="home.html">School Citizen Assemblies</a></h1>
        </header>

        <main>
            <div class="form_container">
                <h1>Sign Up</h1>
                <hr />
                <h2><?php echo $_GET["level"]?></h2>

                <form action="phpScripts/login.php">
                    <input id="email_input" name="email" type="email" placeholder="E-mail" required>

                    <input id="password_input" name="password" type="password" placeholder="Password" required>
                    <img src="assets/noEye.png">

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
        document.querySelector("img").addEventListener("click", swap_visibility);
        function swap_visibility(event) {
            const password_input = document.querySelector('#password_input');

            if(password_input.type == "password") {
                password_input.type = "text";
                event.target.src = "assets/openEye.png";
            } else {
                password_input.type = "password";
                event.target.src = "assets/noEye.png";
            }
        }

        document.querySelector("#password_input").addEventListener("input", password_validate);
        function password_validate() {
            const password_input = document.querySelector("#password_input");
            const password = password_input.value;

            if(password.length < 8) {
                password_input.tooShort = true;
            } else if((password.match(/[A-Z]/g) || []).length < 1) {
                password_input.setCustomValidity("Password requires at least 1 uppercase character");
            } else if((password.match(/[a-z]/g) || []).length < 1) {
                password_input.setCustomValidity("Password requires at least 1 lowercase character");
            } else if((password.match(/[0-9]/g) || []).length < 1) {
                password_input.setCustomValidity("Password requires at least 1 numeric character");
            } else {
                password_input.setCustomValidity("");
            }

            password_input.reportValidity();
        }
    </script>
</html>