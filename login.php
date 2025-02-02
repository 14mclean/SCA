<?php
    header("Location: work-in-progress.html");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Log In - SCA</title>
        <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
        <link rel="stylesheet" href="css/login.css">
    </head>

    <body>
        <header>
            <a class="back_arrow" href="javascript:history.back()">🠔</a>
            <h1><a href="/">School Citizen Assemblies</a></h1>
        </header>

        <main>
            <div class="form_container">
                <h1>Log In</h1>

                <form onsubmit="check_credentials(this); return false;" action="phpScripts/login.php" method="POST">
                    <input id="email_input" name="email" type="email" placeholder="E-mail" required>

                    <input id="password_input" name="password" type="password" placeholder="Password" required>
                    <svg class="visiblity-eye closed" width="20px" height="20px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path/>
                    </svg>

                    <a id="forgot-button" href="forgot-password.html">Forgot Password?</a>

                    <p id="bad-login">The email and/or password is not valid, please try again.</p>
                    <p id="unverified-email">The email address associated with this account has not been validated</p>
                    
                    <input id="last" type="text" style="display: none;">

                    <a class="register-button">Register Here</a>

                    <button>Login</button>
                </form>
            </div>
        </main>

        <div class="decision-blur">
            <a id="teacher-decision" href="register.php?level=Teacher">
                <h1>User/Teacher</h1>
                <p>If you want to search through the directory for resources provided by experts</p>
            </a>

            <a id="expert-decision" href="register.php?level=Expert">
                <h1>Expert</h1>
                <p>If you want to contribute your knowledge and resources to the directory and the users searching it.</p>
            </a>
        </div>
    </body>

    <script src="javascript/login.js"></script>
</html>