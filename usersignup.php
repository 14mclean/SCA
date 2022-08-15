<?php 
    function getGet($index) {
        try {
            return $_GET[$index];
        } catch(Exception $e) {
            return NULL;
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/usersignup.css">
        
    </head>

    <body>
        <a class="homeButton" href="scahome.html"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/30/Home_free_icon.svg/1200px-Home_free_icon.svg.png"></a>

        <div class="container">
            <h1>Sign Up</h1>

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

            <form method="post" action="php/teacherSignup.php"> 
                <input type="email" placeholder="Email" name="email" id="email"><br>
                <input type="password" placeholder="Password" name="password" id="passwordObscured"> <img class="eyeIcon" src="assets/openEye.png">
                <button type="submit">Sign Up</button>
            </form>

            <p>
                Have an account? <br>
                <a href="userlogin.php">Login</a>
            </p>
        </div>
    </body>
    <script src="javascript/passwordVisibility.js"></script>
</html>