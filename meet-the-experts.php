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
        <title>Meet the Experts - SCA</title>
        <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
        <link rel="stylesheet" href="css/meet-the-experts.css">
    </head>

    <body>
        <header>
            <h1 id="title-heading"><a href="index.php">School Citizen Assemblies</a></h1>

            <div id="burger">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>

            <nav id="menu">
                <a href="about.php">About Us</a>
                <a>Teacher Resources</a>
                <a href="meet-the-experts.php">Meet The Experts</a>
            </nav>

            <nav id="subnav">
                <a href="expert-resources.php">Expert Resources</a>
                <a href="directory.php">Directory</a>

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

    <script>
        const menu = document.querySelector("#menu");
        const sub_menu = document.querySelector("#subnav");
        const burger = document.querySelector("#burger")

        burger.addEventListener("click", (event) => {
            if(menu.style.transform == "translateX(0px)") {
                menu.style.transform = "translateX(150px)";
                sub_menu.style.transform = "translateX(150px)";
                burger.style.position = "absolute";
            } else {
                menu.style.transform = "translateX(0px)";
                sub_menu.style.transform = "translateX(0px)";
                burger.style.position = "fixed";
            }
        });
    </script>
</html>