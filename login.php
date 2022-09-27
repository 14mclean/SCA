<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="css/login.css">
    </head>

    <body>
        <a class="homeButton" href="home.html"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/30/Home_free_icon.svg/1200px-Home_free_icon.svg.png"></a>

        <div class="container">
            <h1>Meet the Experts Login</h1>
            
            <form method="post" action="phpScripts/login.php">
                <div class="loginError" <?php if(!isset($_GET['loginError'])) {?>style="display:none"<?php } ?>>
                    <?php 
                        if($_GET["loginError"] == "login") {
                            echo "Incorrect Username or Password";
                        } else if($_GET["loginError"] == "verifiedEmail") {
                            echo "Verify your email before logging in";
                        }
                    ?>
                    
                </div>

                <input type="email" placeholder="Email" name="email" id="email"><br>
                <input type="password" placeholder="Password" name="password" id="passwordObscured"> <img class="eyeIcon" src="assets/openEye.png">
                <button type="submit">Login</button>
            </form>
            
            <p>
                or <br>
                <a href="signupDecision.html">Sign Up</a>
            </p>
        </div>
    </body>
    <script src="javascript/passwordVisibility.js"></script>
</html>