<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/userlogin.css">
    </head>

    <body>
        <a class="homeButton" href="scahome.html"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/30/Home_free_icon.svg/1200px-Home_free_icon.svg.png"></a>

        <div class="container">
            <h1>Teacher Login</h1>
            
            <form method="post" action="php/teacherlogin.php">
                <?php if(isset($_POST['loginError'])): ?>
                    <div class="loginError">
                        Incorrect Username or Password
                    </div>
                <?php endif; ?>
                <input type="email" placeholder="Email" name="email" id="email"><br>
                <input type="password" placeholder="Password" name="password" id="passwordObscured"> <img class="eyeIcon" src="assets/openEye.png">
                <button type="submit">Login</button>
            </form>
            
            <p>
                or <br>
                <a href="usersignup.html">Sign Up</a>
            </p>
        </div>

        <a class="expertRedirect" href="expertlogin.html">Expert Login</a>
    </body>
    <script src="javascript/passwordVisibility.js"></script>
</html>