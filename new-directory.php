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

<!--
    PHPness:
     / start with check login info
     / re-add php for header (myaccount, etc.)
     - get all unique orgs from experts
     - if GET variable active, show checked box
     - if student interaction checked, show student interactions filters
     - show results fitting to GET variables
-->

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Directory - SCA</title>
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel='stylesheet'>
        <link rel="stylesheet" href="css/template.css">
        <link rel="stylesheet" href="css/new-directory.css">
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
                    </li>

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

        <main id="content">
            <div id="search-bar">
                <input type="text" placeholder="Search Expertise">
                <img src="../assets/searchIcon.png">
            </div>

            <aside id="filters">
                <section class="filter-item">
                    <h3 class="filter-item-title">Organisation</h3>

                    <ul class="filter-list">
                        <!--<li>
                            <div class="custom-checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </div>

                            <span class="filter-label">Test Ltd</span>
                        </li>-->

                        <?php

                        $statement = $connection->prepare("SELECT DISTINCT Organisation FROM Expert WHERE admin_verified=1");
                        $statement->execute();
                        $result = $statement->fetchAll();

                        if($result) {
                            foreach($result as &$row) {
                                $org = $row["Organisation"];
        
                                echo("
                                <li>
                                    <div class=\"custom-checkbox\">
                                        <input type=\"checkbox\">
                                        <span class=\"checkmark\"></span>
                                    </div>

                                    <span class=\"filter-label\">$org</span>
                                </li>
                                ");
                            }
                        }

                        ?>
                    </ul>
                </section>

                <section class="filter-item">
                    <h3 class="filter-item-title">Ages</h3>

                    <ul class="filter-list">
                        <li>
                            <div class="custom-checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </div>

                            <span class="filter-label">KS1</span>
                        </li>

                        <li>
                            <div class="custom-checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </div>

                            <span class="filter-label">KS2</span>
                        </li>

                        <li>
                            <div class="custom-checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </div>

                            <span class="filter-label">KS3</span>
                        </li>

                        <li>
                            <div class="custom-checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </div>

                            <span class="filter-label">KS4</span>
                        </li>

                        <li>
                            <div class="custom-checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </div>

                            <span class="filter-label">KS5</span>
                        </li>
                    </ul>
                </section>

                <section class="filter-item">
                    <h3 class="filter-item-title">Interaction Types</h3>

                    <ul class="filter-list">
                        <li>
                            <div class="custom-checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </div>

                            <span class="filter-label">Teacher Advice & Information</span>
                        </li>

                        <li>
                            <div class="custom-checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </div>

                            <span class="filter-label">Student Interaction</span>
                        </li>

                        <li>
                            <div class="custom-checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </div>

                            <span class="filter-label">Project Work</span>
                        </li>
                    </ul>
                </section>

                <section class="filter-item">
                    <h3 class="filter-item-title">Student Interactions</h3>

                    <ul class="filter-list">
                        <li>
                            <div class="custom-checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </div>

                            <span class="filter-label">Face-to-Face</span>
                        </li>

                        <li>
                            <div class="custom-checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </div>

                            <span class="filter-label">Online</span>
                        </li>

                        <li>
                            <div class="custom-checkbox">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                            </div>

                            <span class="filter-label">Resources</span>
                        </li>
                    </ul>
                </section>

                <section class="filter-item">
                    <h3 class="filter-item-title">Distance</h3>

                    <ul class="filter-list">
                        <li>
                            <input type="range" name="distanceRange" min="1" max="180" value="30mi" oninput="this.nextElementSibling.value = this.value+'mi'">
                            <output id="distance-value">30mi</output>
                        </li>

                        <li>
                            <button id="enter-distance">Go</button>
                        </li>
                    </ul>
                </section>
            </aside>

            <main id="results">

            </main>
        </main>

        <footer>
            <h2>© School Citizen Assemblies</h2>

            <p>support@schoolcitizenassemblies.org</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/fuzzysort@2.0.4/fuzzysort.min.js"></script>
        <script src="javascript/header.js"></script>
        <script src="javascript/new-directory.js"></script>
    </body>
</html>