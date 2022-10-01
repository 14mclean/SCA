<?php 
    function getGet($index) {
        if(isset($_GET[$index])) {
            return $_GET[$index];
        } else {
            return NULL;
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/expertsignup.css">
    </head>

    <body>
        <a class="homeButton" href="home.html"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/30/Home_free_icon.svg/1200px-Home_free_icon.svg.png"></a>
        
        <div class="container">
            <h1>Expert Sign Up</h1>

            <div class="loginError">
                <?php 
                    if(getGet("charLengthError") == "true") {
                        echo("Password must to be at least 8 characters long<br>");
                    }

                    if(getGet("numError") == "true") {
                        echo("Password must contain at least 1 number<br>");
                    }

                    if(getGet("uppercaseError") == "true") {
                        echo("Password must contain at least 1 uppercase character<br>");
                    }

                    if(getGet("lowercaseError") == "true") {
                        echo("Password must contain at least 1 lowercase character<br>");
                    }

                    if(getGet("emailTakenError") == "true") {
                        echo("Email has already been taken");
                    }
                ?>
            </div>

            <form method="post" action="phpScripts/expertSignup.php"> 
                <input type="email" placeholder="Email" name="email" id="email" required="required"><br>
                <input type="password" placeholder="Password" name="password" id="passwordObscured" autocomplete="new-password" required="required"> <img class="eyeIcon" src="assets/openEye.png">
                <button type="submit">Sign Up</button>
            </form>

            <p>
                Already have an account? <br>
                <a href="login.php">Login</a>
            </p>
        </div>

        <a class="userSignup" href="usersignup.php">
            User Sign Up
        </a>
    </body>
    <script src="javascript/passwordVisibility.js"></script>
</html>