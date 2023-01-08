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
        <title>Expert Resources - SCA</title>
        <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
        <link rel="stylesheet" href="css/expert-resources.css">
    </head>

    <body>
        <header>
            <h1 id="title-heading"><a href="/">School Citizen Assemblies</a></h1>

            <nav id="menu">
                <svg id="close-nav" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" overflow="visible" stroke="#ddd" stroke-width="6" stroke-linecap="round">
                    <line x2="50" y2="50" />
                    <line x1="50" y2="50" />
                 </svg>

                <ul>
                    <li>
                    <button class="nav-button" id="about" onclick="location.href='about.php';">About Us</button>
                    </li>
                    <li>
                        <button class="nav-button" id="teacher-resources" onclick="show_subnav(event)">Teacher Resources</button>

                        <div class="subnav" id="teacher-resources">
                            <a>Student Resources</a>
                            <a>Teacher Resources</a>
                            <a>SCA Toolkit</a>
                        </div>
                    </li>
                    <li>
                        <button class="nav-button" id="mte" onclick="show_subnav(event)">Meet The Experts</button>

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
                                <button class="nav-button" id="my-account" onclick="show_subnav(event)">My Account</button>

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
            <p class="arrow" id="left" onclick="order_resources(1)">⮜</p>

            <div id="coverflow">
                <div class="coverflow-item">
                    <img src="assets/chesterzoo.png">
                    <h2>Chester Zoo</h2>
                </div> 

                <div class="coverflow-item">
                    <img src="assets/nationalTrust.jpg">
                    <h2>National Trust</h2>
                </div>

                <div class="coverflow-item">
                    <img src="assets/oxfam.png">
                    <h2>Oxfam</h2>
                </div>

                <div class="coverflow-item">
                    <img src="assets/UoM.png">
                    <h2>University of Manchester</h2>
                </div>

                <div class="coverflow-item">
                    <img src="assets/wwf.jpg">
                    <h2>WWF</h2>
                </div>
            </div>

            <p class="arrow" id="right" onclick="order_resources(-1)">⮞</p>
        </main>

        <footer>
            <h1>School Citizen Assemblies</h1>

            <p>info@schoolcitizenassemblies.org</p>
        </footer>
    </body>

    <script src="header.js"></script>
    <script>
        let resource_tiles = Array.from(document.querySelectorAll(".coverflow-item"));

        document.addEventListener("touchstart", swipe_start);

        function swipe_start(event) {
            for(const tile of resource_tiles) {
                tile.style.transition = "linear 0s";
            }

            const initial_x = event.clientX ?? event.touches[0].clientX;
            let moving_item = null;
                  
            for(const tile of resource_tiles) {
                if(tile.style.opacity == "1") {
                    moving_item = tile;
                    break;
                }
            }

            document.addEventListener("touchmove", swipe_move);

            function swipe_move(event) {
                const current_x = event.clientX ?? event.changedTouches[0].clientX;
                const x_delta = current_x-initial_x;

                moving_item.style.transform = "translate(calc(" + x_delta + "px - 50%), -50%)";
            }

            document.addEventListener("touchend", swipe_end);

            function swipe_end(event) {
                const current_x = event.clientX ?? event.changedTouches[0].clientX;
                const x_delta = current_x-initial_x;

                if(Math.abs(x_delta) > 80) {
                    for(const tile of resource_tiles) {
                        tile.style.transition = "ease-in 0.2s";
                    }
                    
                    order_resources(-Math.sign(x_delta));
                } else {
                    moving_item.style.transform = "translate(calc(0vw - 50%), -50%)";
                }

                document.removeEventListener("mousemove", swipe_move);
                document.removeEventListener("touchmove", swipe_move);
                document.removeEventListener("mouseup", swipe_end);
                document.removeEventListener("touchend", swipe_end);
            }
        }

        function order_resources(shift) {
            if(shift == -1) {
                resource_tiles.push(resource_tiles.shift());
            } else if(shift == 1) {
                resource_tiles.unshift(resource_tiles.pop());
            }

            for(let i = 0; i < resource_tiles.length; i++) {
                let t = (Math.round(resource_tiles.length/2-i))*100;
                
                if(t == 0) {
                    resource_tiles[i].style.opacity = "1";
                } else {
                    resource_tiles[i].style.opacity = "0";
                }

                resource_tiles[i].style.transform = "translate(calc("+t+"vw - 50%), -50%)";
            }
        }

        order_resources();
    </script>
</html>