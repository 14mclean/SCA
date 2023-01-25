<?php
    session_start();
    if(isset($_SESSION["user_id"])) {
        $logged_in = true;
        $user_level = $_SESSION["user_level"];
    } else {
        header("Location: login.html");
        exit();
    }
    include_once("api/Database.php");

    $db = new Database("localhost", "SchoolCitizenAssemblies", "mwd3iqjaesdr", "cPanMT3");
    $connection = $db->get_connection();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Directory - SCA</title>
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel='stylesheet'>
        <link rel="stylesheet" href="css/template.css">
        <link rel="stylesheet" href="css/directory.css">
    </head>

    <body>
        <header>
            <h1 id="title-heading">
                <a href="/">School Citizen Assemblies</a>
            </h1>

            <nav id="menu">
                <svg id="close-nav" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" overflow="visible" stroke="#ddd" stroke-width="6" stroke-linecap="round">
                    <line x2="50" y2="50" />
                    <line x1="50" y2="50" />
                 </svg>

                <ul id="nav-list">
                    <li>
                        <button class="nav-button" id="about">About Us</button>
                    </li>

                    <li>
                        <button class="nav-button collapsable" id="teacher-resources">Teacher Resources</button>

                        <ul class="subnav" id="teacher-resources">
                            <li><a>Student Resources</a></li>
                            <li><a>Teacher Resources</a></li>
                            <li><a>SCA Toolkit</a></li>
                        </ul>
                    </li>

                    <li>
                        <button class="nav-button collapsable" id="mte">Meet The Experts</button>

                        <ul class="subnav" id="mte">
                            <li><a href="meet-the-experts.php">Meet The Experts</a></li>
                            <li><a href="expert-resources.php">Expert Resources</a></li>
                            <li><a href="directory.php">Directory</a></li>
                        </ul>

                    <?php

                    if($logged_in) {
                        echo('
                            <li>
                                <button class="nav-button collapsable" id="my-account">My Account</button>

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
                                <button class="nav-button" id="login">Login</button>
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
            <aside>
                <div class="refinement" id="organisation">
                    <h2>
                        Organisation
                        
                        <div class="expand-button" onclick="hide_refinement(this.parentElement.parentElement)">
                            <span id="vertical"></span>
                            <span id="horizontal"></span>
                        </div>
                    </h2>

                    <?php

                    $statement = $connection->prepare("SELECT DISTINCT Organisation FROM Expert WHERE admin_verified=1");
                    $statement->execute();
                    $result = $statement->fetchAll();

                    if($result) {
                        foreach($result as &$row) {
                            $org = $row["Organisation"];
    
                            echo("
                            <label class='custom-checkbox'>
                                $org
                                <input type='checkbox' value='$org'>
                                <span class='new-checkbox'></span>
                            </label>
                            ");
                        }
                    }
                    ?>
                </div>

                <div class="refinement" id="ages">
                    <h2>
                        Ages
                        <div class="expand-button" onclick="hide_refinement(this.parentElement.parentElement)">
                            <span id="vertical"></span>
                            <span id="horizontal"></span>
                        </div>
                    </h2>

                    <label class="custom-checkbox">
                        KS1
                        <input type="checkbox" value="ks1">
                        <span class="new-checkbox"></span>
                    </label>

                    <label class="custom-checkbox">
                        KS2
                        <input type="checkbox" value="ks2">
                        <span class="new-checkbox"></span>
                    </label>

                    <label class="custom-checkbox">
                        KS3
                        <input type="checkbox" value="ks3">
                        <span class="new-checkbox"></span>
                    </label>

                    <label class="custom-checkbox">
                        KS4
                        <input type="checkbox" value="ks4">
                        <span class="new-checkbox"></span>
                    </label>

                    <label class="custom-checkbox">
                        KS5
                        <input type="checkbox" value="ks5">
                        <span class="new-checkbox"></span>
                    </label>
                </div>

                <div class="refinement" id="interactions">
                    <h2>
                        Interaction Types
                        <div class="expand-button" onclick="hide_refinement(this.parentElement.parentElement)">
                            <span id="vertical"></span>
                            <span id="horizontal"></span>
                        </div>
                    </h2>
                    
                    <label class="custom-checkbox">
                        Teacher Advice & Information
                        <input type="checkbox" value="teacher_advice">
                        <span class="new-checkbox"></span>
                    </label>

                    <label class="custom-checkbox">
                        Student Interaction
                        <input type="checkbox" onclick="show_interactions()" value="student_interactions">
                        <span class="new-checkbox"></span>
                    </label>

                    <label class="custom-checkbox">
                        Project Work
                        <input type="checkbox" value="project_work">
                        <span class="new-checkbox"></span>
                    </label>
                </div>

                <div class="refinement" id="student-interactions">
                    <h2>
                        Student Interactions
                        <div class="expand-button" onclick="hide_refinement(this.parentElement.parentElement)">
                            <span id="vertical"></span>
                            <span id="horizontal"></span>
                        </div>
                    </h2>
                    
                    <label class="custom-checkbox">
                        Online
                        <input type="checkbox" value="student-online">
                        <span class="new-checkbox"></span>
                    </label>

                    <label class="custom-checkbox">
                        Face-to-Face
                        <input type="checkbox" value="student_f2f">
                        <span class="new-checkbox"></span>
                    </label>

                    <label class="custom-checkbox">
                        Resources
                        <input type="checkbox" value="student_resources">
                        <span class="new-checkbox"></span>
                    </label>
                </div>

                <div class="refinement" id="distance">
                    <h2>
                        Distance
                        <div class="expand-button" onclick="hide_refinement(this.parentElement.parentElement)">
                            <span id="vertical"></span>
                            <span id="horizontal"></span>
                        </div>
                    </h2>
                    
                    <input type="range" name="distanceRange" min="1" max="180" value="30" oninput="this.nextElementSibling.value = this.value" disabled>
                    <output>30</output><p>mi</p>
                </div>
            </aside>

            <div id="right">
                <div id="search-container">
                    <input type="text" placeholder="Search Expertise">
                    <img src="assets/searchIcon.png" onclick="search()">
                </div>
                
                <div id="results">
                </div>
            </div>
        </main>

        <footer>
            <h2>© School Citizen Assemblies</h2>

            <p>support@schoolcitizenassemblies.org</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/fuzzysort@2.0.4/fuzzysort.min.js"></script>
        <script src="javascript/header.js"></script>
        <script src="javascript/directory.js"></script>
    </body>
</html>