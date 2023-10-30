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
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>School Citizen Assemblies</title>
        <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
        <link rel="stylesheet" href="css/template.css">
        <link rel="stylesheet" href="css/index.css">
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
                            <li><a href="toolkits.php">SCA Toolkit/Guides</a></li>
                            <li><a>Student Resources</a></li>
                            <!--<li><a>Teacher Resources</a></li>-->
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
                            echo('<a href="admin-panel.php">Admin Panel</a>');
                        } else if($user_level == "Expert") {
                            echo("<a href=\"expert-profile.php\">Profile</a>");
                        }
                        echo('
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
            <div class="first-section">
                <!--<h1>School Citizen Assemblies</h1>-->

                <img src="assets/homepage.png" alt="SCA title and motto">
                <a href="https://new.express.adobe.com/webpage/jnLw2uNAXYQ1g">Click here for the full SCA doc</a>

                <!--<h2><i>Assembling and empowering young people, experts and stakeholders to tackle real world challanges</i></h2>-->
            </div>
            
            <div class="second-section">
                <h1>An Inclusive & Impactful Challange Led Learning and Engagement Toolkit</h1>
                <p class="p1">Empowers young people to tackle real world challanges and develop a wide range of learning outcomes through engaging cirriculum design</p>
                <p class="p2">Connects communities, experts and stakeholders to understand complex problems and develop innovative solutions together</p>
                <p class="p3">By enacting choices, voices and actions we can join together to make a real difference to policy, practise and the world around us</p>
            </div>

            <div class="third-section">
                <h1>Learning Outcomes</h1>
                <ul>
                    <li>Knowledge & Understanding</li>
                    <li>Empathy & Compassion</li>
                    <li>Pupil Voice and agency</li>
                    <li>Real world learning</li>
                    <li>High Order Thinking</li>
                    <li>Collaboration & Teamwork</li>
                    <li>Communicate & Inspire</li>
                    <li>Inclusivity Diversity</li>
                    <li>Commitment, Resilience & Community Engagement</li>
                </ul>
            </div>

            <div class="forth-section">
                <h1>School Citizen Assemblies Model</h1>

                <img src="assets/sca_model.png" alt="The SCA model">
            </div>

            <div class="fifth-section">
                b
            </div>
        </main>

        <footer>
            <h2>© School Citizen Assemblies</h2>

            <p>support@schoolcitizenassemblies.org</p>
        </footer>

        <script src="javascript/header.js"></script>
    </body>
</html>