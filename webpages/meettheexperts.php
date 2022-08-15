<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>School Citizen Assemblies</title>
        <link rel="stylesheet" href="../css/global.css">
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/meettheexperts.css">
    </head>
    <body>
        <header>
            <img class="logo" src="../assets/tempLogo.png" alt="SCA Logo">
            
            <nav class="navbar">
                <a href="scahome.html" id="homeMenu"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/30/Home_free_icon.svg/1200px-Home_free_icon.svg.png"></a>
                
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
                if(isset($_SESSION["email"])) {
                    echo( '
                        <a href="../phpScripts/logout.php" class="loginButton">Logout</a>
                    ' );
                } else {
                    echo( '
                        <a href="userlogin.php" class="loginButton">Login</a>
                    ' );
                }
            ?>
            
        </header>
        
        <content>
            <p>Meet The Experts</p>
        </content>
    </body>
    
    <script src="../javascript/navbar.js"></script>
</html>