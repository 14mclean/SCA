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

    $ages = "";
    $teacherAdvice = false;
    $projectWork = false;
    $studentOnline = false;
    $studentF2F = false;
    $studentResources = false;
    $location = "";

    include_once("../phpScripts/database.php");
    $db = new Database();

    $statement = $db->prepareStatement(
        "SELECT email, expertise, organisation, ages, teacherAdvice, projectWork, studentOnline, studentF2F, studentResources, Experts.location FROM Users INNER JOIN Experts ON Users.userID = Experts.userID WHERE Users.userID = ?",
        "i",
        array($userID)
    );

    $result=$db->sendQuery(
        $statement,
        array(
            "email",
            "expertise",
            "org",
            "ages",
            "teacherAdvice",
            "projectWork",
            "studentOnline",
            "studentF2F",
            "studentResources",
            "location"
        )
    );

    $email = $result[0]["email"];
    $expertise = $result[0]["expertise"];
    $org = $result[0]["org"];
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

                    <h1><?php echo($email); ?></h1> <br>

                    <div class="field">
                        <label>Expertise</label>
                        <input type="text" name="expertise" value="<?php echo($expertise); ?>">
                    </div>

                    <div  class="field">
                        <label>Organisation (if applicable)</label>
                        <input type="text" name="company" value="<?php echo($org); ?>">
                    </div>

                    <div  class="field">
                        <label>
                            Ages
                        </label>

                        <div>
                            <label>KS1</label> <input type="checkbox">
                            <label>KS2</label> <input type="checkbox">
                            <label>KS3</label> <input type="checkbox">
                            <label>KS4</label> <input type="checkbox">
                            <label>KS5</label> <input type="checkbox">
                        </div>
                    </div>
                    
                    <div class="field">
                        <label>Teacher Advice & Information</label>
                        <input type="checkbox">
                    </div>
                    
                    <div class="field">
                        <label>Project Work</label>
                        <input type="checkbox">
                    </div>
                    
                    <div class="field">
                        <label>Student Interaction</label>
                        <input type="checkbox">

                        <div>
                            <label>Online</label>
                            <input type="checkbox">
                        </div>

                        <div>
                            <label>Face-to-Face</label>
                            <input type="checkbox">
                        </div>

                        <div>
                            <label>Resources</label>
                            <input type="checkbox">
                        </div>
                    </div>

                    <div class="field">
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