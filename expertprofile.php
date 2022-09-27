<?php
    session_start();

    $userID = $_SESSION["userID"];
    $userLevel = $_SESSION["userLevel"];

    if(!isset($userID)) {
        header("Location: login.php");
        exit();
        
    } else if($userLevel == "Teacher") {
        header("Location: login.php");
        exit();      
    }

    include_once("phpScripts/database.php");
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
    $ages = array();
    $teacherAdvice = $result[0]["teacherAdvice"] == '1';
    $projectWork = $result[0]["projectWork"] == '1';
    $studentOnline = $result[0]["studentOnline"] == '1';
    $studentF2F = $result[0]["studentF2F"] == '1';
    $studentResources = $result[0]["studentResources"] == '1';
    $location = $result[0]["location"];

    for($i = 0; $i < 5; $i++) {
        array_push($ages, str_contains($result[0]["ages"], "KS".$i));
    }

    $statement = $db->prepareStatement(
        "SELECT name,link FROM ExpertResources WHERE userID=?",
        "i",
        array($userID)
    );

    /*$originalResources = $db->sendQuery(
        $statement,
        array("name", "link")
    );*/
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>School Citizen Assemblies</title>
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/expertprofile.css">
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
        </header>
        
        <content>
            <div class="container">
                <div class="profile">

                    <h1><?php echo($email); ?></h1> <br>

                    <div class="field">
                        <label>Expertise *</label>
                        <input type="text" name="expertise" value="<?php echo($expertise); ?>">
                    </div>

                    <div class="field">
                        <label>Organisation (if applicable)</label>
                        <input type="text" name="company" value="<?php echo($org); ?>">
                    </div>

                    <div class="field">
                        <label>
                            Ages
                        </label>

                        <div>
                            <label>KS1</label> <input type="checkbox" <?php if($ages[0]) echo("checked") ?> > <br>
                            <label>KS2</label> <input type="checkbox" <?php if($ages[1]) echo("checked") ?> > <br>
                            <label>KS3</label> <input type="checkbox" <?php if($ages[2]) echo("checked") ?> > <br>
                            <label>KS4</label> <input type="checkbox" <?php if($ages[3]) echo("checked") ?> > <br>
                            <label>KS5</label> <input type="checkbox" <?php if($ages[4]) echo("checked") ?> > <br>
                        </div>
                    </div>
                    
                    <div class="field">
                        <label>Teacher Advice & Information</label>
                        <input id="teacherAdvice" type="checkbox" <?php if($teacherAdvice) echo("checked") ?> >
                    </div>
                    
                    <div class="field">
                        <label>Project Work</label>
                        <input id="projectWork" type="checkbox" <?php if($projectWork) echo("checked") ?> >
                    </div>
                    
                    <div class="field">
                        <label>Student Interaction</label>
                        <input type="checkbox" name="studentInteraction" <?php if($studentOnline || $studentF2F || $studentResources) echo("checked") ?>>

                        <div>
                            <label id="online">Online</label>
                            <input id="online" type="checkbox" <?php if($studentOnline) echo("checked") ?> >
                        </div>

                        <div>
                            <label id="f2f">Face-to-Face</label>
                            <input id="f2f" type="checkbox" <?php if($studentF2F) echo("checked") ?> >
                        </div>

                        <div>
                            <label id="resources">Resources</label>
                            <input id="resources" type="checkbox" <?php if($studentResources) echo("checked") ?> >
                        </div>
                    </div>

                    <div class="field">
                        <label>Location</label>
                        <input type="text" name="location" value="<?php echo($location); ?>">
                    </div>

                    <div class="field">
                        <label>Resource Links</label>
                        <img class="addResource" src="assets/plus.png">

                        <table class="resourceTable">
                        </table>
                    </div>

                    <br>
                    <button>Save</button>
                </div>
            </div>
        </content>
    </body>
    
    <script src="javascript/navbar.js"></script>
    <script src="javascript/expertProfile.js"></script>
</html>