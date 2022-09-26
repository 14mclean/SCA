<?php
    session_start();

    if(!isset($_SESSION["userID"])) {
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>School Citizen Assemblies</title>
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/directoryresults.css">
    </head>
    <body>
        <header>
            <img class="logo" src="assets/tempLogo.png" alt="SCA Logo">
            
            <nav class="navbar">
                <a href="home.html" id="homeMenu"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/30/Home_free_icon.svg/1200px-Home_free_icon.svg.png"></a>
                
                <div class="dropdown">
                    <button class="dropbtn" onclick="location.href='aboutus.html'">About Us</button>
                    <div class="dropdown-content"></div>
                </div>
                
                <div class="dropdown">
                    <button class="dropbtn" onclick="location.href='teacherresources.html'">Teaching Resources</button>
                    <div class="dropdown-content">
                        <a href="scatoolkit.html">SCA Toolkit</a>
                        <a href="teacherguide.html">Teacher Guide</a>
                        <a href="studentresources.html">Student Resources</a>
                    </div>
                </div>
                
                <div class="dropdown">
                    <button class="dropbtn" onclick="location.href='meettheexperts.php'">Meet the Experts</button>
                    <div class="dropdown-content">
                        <a href="expertresources.html">Expert Resources</a>
                        <a href="directoryresults.php">Directory</a>
                    </div>
                </div>
            </nav>
            
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <?php
                if(isset($_SESSION["userID"])) {
                    echo( '
                        <a href="phpScripts/logout.php" class="loginButton">Logout</a>
                    ' );

                    if($_SESSION["userLevel"] == "Expert") {
                        echo('
                            <a href="expertprofile.php" class="expertProfile">Account</a>
                        ');
                    } else if($_SESSION["userLevel"] == "Admin") {
                        echo('
                            <a href="adminpanel.php" class="adminButton"><img src="assets/adminSettingsIcon.png"></a>
                        ');
                    }

                } else {
                    echo( '
                        <a href="login.php" class="loginButton">Login</a>
                    ' );
                }
            ?>
        </header>
        
        <content>
            <div class="refinements"> 
                <h1>Refine Search</h1>

                <div class="refine">
                    <h1>Organisation</h1>

                    <input type="checkbox" name="wwf"><label>WWF</label><br>
                    <input type="checkbox" name="nationaltrust"><label>National Trust</label><br>
                    <input type="checkbox" name="mbs"><label>Manchester University</label><br>
                    <input type="checkbox" name="unicef"><label>Unicef</label><br>
                    <input type="checkbox" name="oxfam"><label>Oxfam</label>
                </div>

                <div class="refine">
                    <h1>Ages</h1>

                    <input type="checkbox" name="age1"><label>KS1</label><br>
                    <input type="checkbox" name="age2"><label>KS2</label><br>
                    <input type="checkbox" name="age3"><label>KS3</label><br>
                    <input type="checkbox" name="age4"><label>KS4</label><br>
                    <input type="checkbox" name="age5"><label>KS5</label>
                </div>

                <div class="refine">
                    <h1>Interaction Types</h1>

                    <input type="checkbox" name="teacherAdvice"><label>Teacher Advice & Information</label><br>
                    <input type="checkbox" name="studentInteraction" id="studentInteractionCheck"><label>Student Interaction</label><br>
                    <input type="checkbox" name="projectWork"><label>Project Work</label>
                </div>

                <div class="refine" id="studentInteractions">
                    <h1>Student Interactions</h1>

                    <input type="checkbox" name="online"><label>Online</label><br>
                    <input type="checkbox" name="f2f"><label>Face-to-Face</label><br>
                    <input type="checkbox" name="resources"><label>Resources</label>
                </div>

                <div class="refine" id="distance">
                    <h1>Distance</h1>

                    <input type="text" name="outcode" placeholder="Outcode"><br>
                    <input type="range" name="distanceRange"><br>
                    <p class="distanceOutput"><span id="distanceDisplay"></span>mins</p>
                </div>
            </div>

            <div class="main">
                <div class="search">
                    <input type="text" placeholder="Search expertise">
                    <img src="assets/searchIcon.png">
                </div>
                
    
                <div class="results"> 
                    <div class="item">
                        result item
                    </div>

                    <div class="item">
                        result item
                    </div>

                    <div class="item">
                        result item
                    </div>

                    <div class="item">
                        result item
                    </div>

                    <div class="item">
                        result item
                    </div>

                    <div class="item">
                        result item
                    </div>

                    <div class="item">
                        result item
                    </div>

                    <div class="item">
                        result item
                    </div>

                    <div class="item">
                        result item
                    </div>

                    <div class="item">
                        result item
                    </div>

                    <div class="item">
                        result item
                    </div>

                    <div class="item">
                        result item
                    </div>

                    <div class="item">
                        result item
                    </div>

                    <div class="item">
                        result item
                    </div>
                </div>
            </div>

            <div class="padding"> </div>
        </content>

        <div class="overlay">
            <h1>Top Searches</h1>

            <div class="area">
                <h2>Pollution</h2>
            </div>

            <div class="area">
                <h2>Food</h2>
            </div>

            <div class="area">
                <h2>Biodiversity</h2>
            </div>

            <div class="area">
                <h2>Water</h2>
            </div>

            <div class="area">
                <h2>Climate</h2>
            </div>
        </div>
    </body>
    <script src="javascript/navbar.js"></script>
    <script src="javascript/directoryResults.js"></script>
</html>