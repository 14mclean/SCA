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