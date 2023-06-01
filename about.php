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
        <title>About - SCA</title>
        <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
        <link rel="stylesheet" href="css/template.css">
        <link rel="stylesheet" href="css/about.css">
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
            <h2>About Us</h2>
            <p id="description">T
                he School Citizen Assemblies (SCA) approach was developed initially by Dr Chris McLean (Alliance Manchester Business School: AMBS) with the support of colleagues from around the University of Manchester. This includes Professor Jonatan Pinkse (AMBS); Dr Jennifer O'Brien (Geography) and Dr Louis Major (Manchester Institute of Education). There have also been many others involved in the design, development and application of the SCA and we wish to thank them for all of their contributions, ideas and reflections.
            </p>
        
            <h3 class="name-title">Dr Chris McLean</h3>
            <p class="person-description">
                Chris founded the SCA. Along the journey of designing, developing and implementing the SCA, she has been supported by a wide range of people. She is an academic and educationalist based within the Alliance Manchester Business School (AMBS), at the University of Manchester.<br><br>Chris has a keen interest in curriculum design, assessment, civic engagement and sustainable education. She is also academic lead of the University of Manchester School Governors Initiative.  Through her work she seeks to promote the incredible and inspirational work of schools and teachers and also help them to share and develop innovative teaching and learning approaches. She is also lead of the RSA Innovative Education Network and has been working with primary and secondary schools for many years in the area of education and organisational change.
            </p>
        
            <section id="manchester-team">
                <h2>The University of Manchester Team</h2>

                <div id="team-member">
                    <h3 class="name-title">Dr Jennifer O'Brien</h3>
                    <p class="person-description">
                        Dr. Jennifer O'Brien (PFHEA) is Academic Lead for Sustainability Teaching and Learning at the University of Manchester, UK, and an Inaugural Fellow of the Manchester Institute of Teaching and Learning.  Jen is the Education Lead for Sustainable Futures and directs the University Living Lab which links applied research needed by organisations with students who can undertake it for their assessment to effect change. Working with Education for Sustainable Development particularly through the United Nation's Sustainable Development Goals, Jen aims to inspire and equip learners to ethically address challenges of sustainability, inequality and social justice to effect positive change.
                    </p>
                </div>

                <div id="team-member">
                    <h3 class="name-title">Professor Jonatan Pinkse</h3>
                    <p class="person-description">
                        Jonatan is a Professor of strategy, innovation, and entrepreneurship at the Manchester Institute of Innovation Research (MIoIR), Alliance Manchester Business School, The University of Manchester. His research interests focus on corporate sustainability, business model innovation, social entrepreneurship, cross-sector partnerships, and the sharing economy. In his research, Jonatan analyses how firms make strategic decisions to adapt to a more sustainable economy and deal with the ensuing tensions between issues and actors. He also investigates barriers to firm adoption of disruptive technologies from cognitive, organizational, and institutional perspectives. Before moving to Manchester, he held positions at the Universiteit van Amsterdam and Grenoble Ecole de Management. Jonatan has authored more than 50 scholarly and practitioner articles in a variety of journals.
                    </p>
                </div>

                <div id="team-member">
                    <h3 class="name-title">Dr Louis Major</h3>
                    <p class="person-description">
                        Louis Major is a Senior Lecturer in Digital Education at the Manchester Institute of Education (MIE). His research primarily focuses on digital technology’s role in the future of education, in particular, how this can help to address educational disadvantage and support effective dialogue and communication. He co-leads the Digital Technology, Communication and Education Research and Scholarship group at the University of Manchester. He has also been an Editor of the British Journal of Educational Technology (BJET) since 2020.
                    </p>
                </div>
            </section>
        </main>

        <footer>
            <h2>© School Citizen Assemblies</h2>

            <p>support@schoolcitizenassemblies.org</p>
        </footer>

        <script src="javascript/header.js"></script>
    </body>
</html>