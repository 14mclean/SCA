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
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Directory - SCA</title>
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel='stylesheet'>
        <link rel="stylesheet" href="css/directory.css">
    </head>

    <body>
        <header>
        <h1 id="title-heading"><a href="home.html">School Citizen Assemblies</a></h1>

        <nav id="menu">
                <svg id="close-nav" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" overflow="visible" stroke="#ddd" stroke-width="6" stroke-linecap="round">
                    <line x2="50" y2="50" />
                    <line x1="50" y2="50" />
                 </svg>

                <ul>
                    <li>
                        <button class="nav-button" id="about" onclick="location.href='login.html';">About Us</button>
                    </li>
                    <li>
                        <button class="nav-button" id="teacher-resources" onclick="show_subnav(this)">Teacher Resources</button>

                        <div class="subnav" id="teacher-resources">
                            <a>Student Resources</a>
                            <a>Teacher Resources</a>
                            <a>SCA Toolkit</a>
                        </div>
                    </li>
                    <li>
                        <button class="nav-button" id="mte" onclick="show_subnav(this)">Meet The Experts</button>

                        <div class="subnav" id="mte">
                            <a href="meet-the-experts.php">Meet The Experts</a>
                            <a href="expert-resources.php">Expert Resources</a>
                            <a href="directory.php">Directory</a>
                        </div>
                    </li>

                    <?php

                    if($logged_in) {
                        echo('
                            <li>
                                <button class="nav-button" id="my-account" onclick="show_subnav(this)">My Account</button>

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
                                <button onclick="location.href=\'login.html\';" class="nav-button" id="login">Login</button>
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
            <h1>School Citizen Assemblies</h1>

            <p>info@schoolcitizenassemblies.org</p>
        </footer>
    </body>

    <script src="https://cdn.jsdelivr.net/npm/fuzzysort@2.0.4/fuzzysort.min.js"></script>
    <script src="header.js"></script>
    <script>
    document.querySelectorAll('input[type="checkbox"]').forEach(function(element) {element.addEventListener("change", search())});    

    function hide_refinement(refinement_div) {
        refinement_div.classList.toggle("collapsed");

        const vert_span = refinement_div.firstElementChild.firstElementChild.firstElementChild;
        if(vert_span.style.transform == "rotate(90deg)") {
            vert_span.style.transform = "rotate(0deg)";
        } else {
            vert_span.style.transform = "rotate(90deg)";
        }
    }

    function show_interactions() {
        const student_interactions = document.querySelector("#student-interactions");

        if(student_interactions.style.maxHeight == "200px") {
            student_interactions.style.maxHeight = "0px";
        } else {
            student_interactions.style.maxHeight = "200px";
        }
    }

    function search() {
        let admin_verified = true,
        orgs = [],
        teacher_advice = false,
        project_work = false,
        student_online = false,
        student_f2f = false,
        student_resources = false,
        does_ks1 = false,
        does_ks2 = false,
        does_ks3 = false,
        does_ks4 = false,
        does_ks5 = false,
        expertise_value = document.querySelector("input[type='text']").value;

        for(const org_checkbox of document.querySelectorAll(".refinement#organisation input")) {
            if(org_checkbox.checked) {
                orgs.push(org_checkbox.value);
            }
        }

        for(const interactions_checkbox of document.querySelectorAll(".refinement#interactions input")) {
            if(interactions_checkbox.checked) {
                switch(interactions_checkbox.value) {
                    case "teacher_advice":
                        teacher_advice = true;
                    case "project_work":
                        project_work = true;
                    case "student_interactions":
                        for(const student_interactions_checkbox of document.querySelectorAll(".refinement#student-interactions input")) {
                            if(student_interactions_checkbox.checked) {
                                switch(student_interactions_checkbox.value) {
                                    case "student_online":
                                        student_online = true;
                                    case "student_f2f":
                                        student_f2f = true;
                                    case "student_resources":
                                        student_resources = true;
                                    default:
                                        console.log("Error with value " + student_interactions_checkbox.value);
                                }
                            }
                        }
                    default:
                        console.log("Error with value "+interactions_checkbox.value);
                }
            }
        }

        for(const ages_checkbox of document.querySelectorAll(".refinement#ages input")) {
            if(ages_checkbox.checked) {
                switch(ages_checkbox.value) {
                    case "ks1":
                        does_ks1 = true;
                    case "ks2":
                        does_ks2 = true;
                    case "ks3":
                        does_ks3 = true;
                    case "ks4":
                        does_ks4 = true;
                    case "ks5":
                        does_ks5 = true;
                }
            }
        }

        let filter = {
            "admin_verified": {"operator": "", "value": [1]},
            "organisation": {"operator": "OR", "value": orgs},
            "does_teacher_advice": {"operator": "OR", "value": [+teacher_advice, 1]},
            "does_project_work": {"operator": "OR", "value": [+project_work, 1]},
            "does_student_online": {"operator": "OR", "value": [+student_online, 1]},
            "does_student_f2f": {"operator": "OR", "value": [+student_f2f, 1]},
            "does_student_resource": {"operator": "OR", "value": [+student_resources, 1]},
            "does_ks1": {"operator": "OR", "value": [+does_ks1, 1]},
            "does_ks2": {"operator": "OR", "value": [+does_ks2, 1]},
            "does_ks3": {"operator": "OR", "value": [+does_ks3, 1]},
            "does_ks4": {"operator": "OR", "value": [+does_ks4, 1]},
            "does_ks5": {"operator": "OR", "value": [+does_ks5, 1]}
        };

        // fetch with options
        fetch("/api/experts?filter=" + btoa(JSON.stringify(filter)))
        .then(response => {
            if(response.ok) {
                return response.json();
            }
        })
        .then(json => {
            // *** CHECK LOCATION ***

            // get expertise of all experts post filter
            let filter = {"user_id": {"operator": "OR", "value": []}}
            for(const expert of json) {
                filter["user_id"]["value"].push(expert["user_id"]);
            }

            fetch("/api/expertise?filter=" + btoa(JSON.stringify(filter)))
            .then(async response => {
                if(!response.ok) return;

                const expertise = await response.json();
                const expert_json = json;

                let unique_expertise = new Set();

                for(const record of expertise) {
                    unique_expertise.add(record["expertise"]);
                }

                let results = fuzzysort.go(expertise_value, Array.from(unique_expertise), {threshold: -10000});
                results.forEach(function (element, index) {results[index] = element["t"]});

                let result_elements = Array.from(document.querySelectorAll(".result"));
                result_elements.forEach(function(element, index) {result_elements[index] = element.id});

                for(const result_id of result_elements) {
                    if(result_id == "") continue;

                    let found = false;
                    for(const expert of expert_json) {
                        if("expert"+expert["user_id"] == result_id) {
                            found = true;
                            break;
                        }
                    }
                    if(!found) {
                        document.querySelector(".result#"+result_id).remove();
                        break;
                    }
                }

                outer:
                for(const expert of expert_json) {
                    for(const expertise_instance of expertise) {
                        if(expertise_instance["user_id"] == expert["user_id"] && results.some(x => x.toLowerCase() == expertise_instance["expertise"].toLowerCase())) {
                            if(!result_elements.includes("expert"+expert["user_id"])) { 
                                let result_div = document.createElement("div");
                                let profile_img = document.createElement("img");
                                let result_name = document.createElement("h1");
                                let result_org = document.createElement("h2");

                                result_div.setAttribute("class", "result");
                                result_div.setAttribute("id", "expert"+expert["user_id"]);
                                profile_img.setAttribute("src", "assets/profilePicture.png");
                                
                                result_name.appendChild(document.createTextNode(expert["name"]));
                                result_org.appendChild(document.createTextNode(expert["job_title"] + " at " + expert["organisation"]));
                                result_div.appendChild(profile_img);
                                result_div.appendChild(result_name);
                                result_div.appendChild(result_org);
                                document.querySelector("#results").appendChild(result_div);
                            }
                            break outer;
                        }
                    }
                }
            });
        });
    }

    </script>
</html>