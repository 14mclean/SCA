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
            <h1 id="title-heading"><a href="home.html">School Citizen Assemblies</a></h1>

            <nav id="menu">
                <svg id="close-nav" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" overflow="visible" stroke="#ddd" stroke-width="6" stroke-linecap="round">
                    <line x2="50" y2="50" />
                    <line x1="50" y2="50" />
                 </svg>

                <ul>
                    <li>
                        <button class="nav-button" id="about">About Us</button>
                    </li>
                    <li>
                        <button class="nav-button" id="teacher-resources" onclick="show_subnav(this)">Teacher Resources</button>

                        <div class="subnav" id="teacher-resources">
                            <a>Student Resources</a>
                            <a>Teacher Resources</a>
                            <a>SCA Toolkit</a>
                        </div>
                    </li>
                    <li>
                        <button class="nav-button" id="mte" onclick="show_subnav(this)">Meet The Experts</button>

                        <div class="subnav" id="mte">
                            <a href="meet-the-experts.php">Meet The Experts</a>
                            <a href="expert-resources.php">Expert Resources</a>
                            <a href="directory.php">Directory</a>
                        </div>
                    </li>

                    <?php

                    if($logged_in) {
                        echo('
                            <li>
                                <button class="nav-button" id="my-account" onclick="show_subnav(this)">My Account</button>

                                <div class="subnav" id="my-account">
                        ');
                        if($user_level == "Admin") {
                            echo('<a>Admin Panel</a>');
                        }
                        echo('
                                <a href="expert-profile.php">Profile</a>
                                <a href="phpScripts/logout.php">Logout</a>
                            </div>
                        </li>
                        ');
                    } else {
                        echo('
                            <li>
                                <button onclick="location.href=\'login.html\';" class="nav-button" id="login">Login</button>
                            </li>
                        ');
                    }
                    ?>
                </ul>
            </nav>

            <svg id="burger" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0h24v24H0z" fill="none"></path>
                <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"></path>
            </svg>
        </header>

        <main>
            
        </main>

        <footer>
            <h1>School Citizen Assemblies</h1>

            <p>info@schoolcitizenassemblies.org</p>
        </footer>
    </body>

    <script>
        function show_subnav(element) {
            function open_subnav(nav) {
                document.querySelector(".nav-button#" + nav.id).classList.add("open");
                if(window.matchMedia("(max-width: 990px)").matches) {
                    nav.style.maxHeight = "180px";
                } else {
                    nav.style.transform = "translateY(150px)";
                } 
            }

            function close_subnav(nav) {
                document.querySelector(".nav-button#" + nav.id).classList.remove("open"); 
                if(window.matchMedia("(max-width: 990px)").matches) {
                    nav.style.maxHeight = "0px";
                } else {
                    nav.style.transform = "translateY(0px)";
                }
            }

            const subnav = document.querySelector(".subnav#" + element.id);
            const others = document.querySelectorAll(".subnav:not(#" + element.id + ")");

            for(const other_nav of others) {
                close_subnav(other_nav);
            }

            if(element.classList.contains("open")) {
                close_subnav(subnav);
            } else {
                open_subnav(subnav);
            }
        }
    
        document.querySelector("#burger").addEventListener("click", show_sidebar);
        document.querySelector("#close-nav").addEventListener("click", show_sidebar);

        function show_sidebar() {
            const menu = document.querySelector("#menu");
            const cross = document.querySelector("#close-nav");

            if(menu.style.transform == "translateX(-200px)") {
                menu.style.transform = "translateX(0px)";
                cross.style.transform = "translateX(0px)";
            } else {
                menu.style.transform = "translateX(-200px)";
                cross.style.transform = "translateX(-200px)";
            }
        }
    </script>
</html>