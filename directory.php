<?php
    session_start();
    if(isset($_SESSION["userID"])) {
        $logged_in = true;
        $user_level = $_SESSION["userLevel"];
    } else {
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Directory - SCA</title>
        <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
        <link rel="stylesheet" href="css/directory.css">
    </head>

    <body>
        <header>
            <h1><a href="home.html">School Citizen Assemblies</a></h1>

            <nav>
                <a href="about.php">About Us</a>
                <a>Teacher Resources</a>
                <a href="meet-the-experts.php">Meet The Experts</a>
            </nav>

            <nav class="subnav">
                <a>Expert Resources</a>
                <a href="directory.php">Directory</a>

                <?php
                if($logged_in) {
                    if($user_level == "") {
                        echo('<a>Logout</a>');
                    }
                    
                    if($user_level == "") {
                        echo('<a>Admin Panel</a>');
                    }
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