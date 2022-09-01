<?php
    session_start();

    $userID = $_SESSION["userID"];
    $userLevel = $_SESSION["userLevel"];

    if(!isset($userID)) {
        if($userLevel == "Teacher") {
            header("Location: login.php");
            exit();
        }
    }

    $expertise = "";
    $organisation = "";
    $ages = array();
    $f2f = false;
    $online = false;
    $teacherAdvice = false;
    $location = "";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>School Citizen Assemblies</title>
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/expertprofile.css">
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
        </header>
        
        <content>
            <div class="container">
                <div class="profile">

                    <h1>Namey Name</h1> <br>

                    <div class="field">
                        <label>Expertise</label>
                        <input type="text" name="expertise">
                    </div>

                    <div  class="field">
                        <label>Organisation (if applicable)</label>
                        <input type="text" name="company">
                    </div>

                    <div  class="field">
                        <label>
                            Ages
                            <input mbsc-input id="multiple-select-input" placeholder="Please select..." data-dropdown="true" data-input-style="outline" data-label-style="stacked" data-tags="true"/>
                        </label>

                        
                    </div>
                    
                    <div  class="field">
                        <label>Face-to-Face</label>
                        <input type="checkbox">
                    </div>
                    
                    <div  class="field">
                        <label>Online</label>
                        <input type="checkbox">
                    </div>
                    
                    <div  class="field">
                        <label>Teacher Advice</label>
                        <input type="checkbox">
                    </div>

                    <div  class="field">
                        <label>Location</label>
                        <input type="text" name="location">
                    </div>

                    <br>
                    <button>Save</button>
                </div>
            </div>
        </content>
    </body>
    
    <script src="../javascript/navbar.js"></script>
</html>