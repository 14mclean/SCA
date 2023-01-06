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