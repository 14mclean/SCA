<?php
    session_start();
    if(isset($_SESSION["userID"])) {
        $logged_in = true;
        $user_level = $_SESSION["userLevel"];
    } else {
        header("Location: login.html");
        exit();
    }
    include_once("api/Database.php");

    $db = new Database("localhost", "SchoolCitizenAssemblies", "mwd3iqjaesdr", "cPanMT3");
    $connection = $db->get_connection();
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
                    if($user_level == "Admin") {
                        echo('<a>Admin Panel</a>');
                    }
                    echo('<a href="phpScripts/logout.php">Logout</a>');
                }
                ?>
            </nav>
        </header>

        <main>
        <aside>
                <div class="refinement" id="organisation">
                    <h2>
                        Organisation
                        
                        <div id="expand-button" onclick="hide_refinement(this.parentElement.parentElement)">
                            <span id="vertical"></span>
                            <span id="horizontal"></span>
                        </div>
                    </h2>

                    <?php

                    $statement = $connection->prepare("SELECT DISTINCT Organisation FROM Experts WHERE adminVerified=1");
                    $statement->execute();
                    $result = $statement->fetchAll();

                    foreach($result as &$row) {
                        $org = $row["Organisation"];

                        echo("
                        <label class='custom-checkbox'>
                            $org
                            <input type='checkbox'>
                            <span class='new-checkbox'></span>
                        </label>
                        ");
                    }

                    ?>
                </div>

                <div class="refinement" id="ages">
                    <h2>
                        Ages
                        <div id="expand-button" onclick="hide_refinement(this.parentElement.parentElement)">
                            <span id="vertical"></span>
                            <span id="horizontal"></span>
                        </div>
                    </h2>

                    <label class="custom-checkbox">
                        KS1
                        <input type="checkbox">
                        <span class="new-checkbox"></span>
                    </label>

                    <label class="custom-checkbox">
                        KS2
                        <input type="checkbox">
                        <span class="new-checkbox"></span>
                    </label>

                    <label class="custom-checkbox">
                        KS3
                        <input type="checkbox">
                        <span class="new-checkbox"></span>
                    </label>

                    <label class="custom-checkbox">
                        KS4
                        <input type="checkbox">
                        <span class="new-checkbox"></span>
                    </label>

                    <label class="custom-checkbox">
                        KS5
                        <input type="checkbox">
                        <span class="new-checkbox"></span>
                    </label>
                </div>

                <div class="refinement" id="interactions">
                    <h2>
                        Interaction Types
                        <div id="expand-button" onclick="hide_refinement(this.parentElement.parentElement)">
                            <span id="vertical"></span>
                            <span id="horizontal"></span>
                        </div>
                    </h2>
                    
                    <label class="custom-checkbox">
                        Teacher Advice & Information
                        <input type="checkbox">
                        <span class="new-checkbox"></span>
                    </label>

                    <label class="custom-checkbox">
                        Student Interaction
                        <input type="checkbox">
                        <span class="new-checkbox"></span>
                    </label>

                    <label class="custom-checkbox">
                        Project Work
                        <input type="checkbox">
                        <span class="new-checkbox"></span>
                    </label>
                </div>

                <div class="refinement" id="student-interactions">
                    <h2>
                        Student Interactions
                        <div id="expand-button" onclick="hide_refinement(this.parentElement.parentElement)">
                            <span id="vertical"></span>
                            <span id="horizontal"></span>
                        </div>
                    </h2>
                    
                    <label class="custom-checkbox">
                        Online
                        <input type="checkbox">
                        <span class="new-checkbox"></span>
                    </label>

                    <label class="custom-checkbox">
                        Face-to-Face
                        <input type="checkbox">
                        <span class="new-checkbox"></span>
                    </label>

                    <label class="custom-checkbox">
                        Resources
                        <input type="checkbox">
                        <span class="new-checkbox"></span>
                    </label>
                </div>

                <div class="refinement" id="distance">
                    <h2>
                        Distance
                        <div id="expand-button" onclick="hide_refinement(this.parentElement.parentElement)">
                            <span id="vertical"></span>
                            <span id="horizontal"></span>
                        </div>
                    </h2>
                    
                    <input type="range" name="distanceRange" min="1" max="180" value="30" oninput="this.nextElementSibling.value = this.value">
                    <output>30</output><p>mi</p>
                </div>
            </aside>

            <div id="results">
                test
            </div>
        </main>

        <footer>
            <h1>School Citizen Assemblies</h1>

            <p>info@schoolcitizenassemblies.org</p>
        </footer>
    </body>
</html>