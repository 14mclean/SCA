<?php
    session_start();
    if(isset($_SESSION["user_id"])) {
        $logged_in = true;
        $user_level = $_SESSION["user_level"];
    } else {
        $logged_in = false;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>About - SCA</title>
        <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
        <link rel="stylesheet" href="css/about.css">
    </head>

    <body>
        <header>
            <h1><a href="home.html">School Citizen Assemblies</a></h1>

            <div id="burger">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>

            <nav>
                <a href="about.html">About Us</a>
                <a>Teacher Resources</a>
                <a href="meet-the-experts.php">Meet The Experts</a>
            </nav>

            <nav class="subnav">
            <?php
                if($logged_in) {                    
                    if($user_level == "Admin") {
                        echo('<a>Admin Panel</a>');
                    }
                    echo('<a href="expert-profile.php">Profile</a>');
                    echo('<a href="phpScripts/logout.php">Logout</a>');
                } else {
                    echo('<a href="login.html">Log In</a>');
                }
                ?>
            </nav>
        </header>

        <main>
            
        </main>

        <footer>
            <h1>School Citizen Assemblies</h1>

            <p>info@schoolcitizenassemblies.org</p>
        </footer>
    </body>
</html>