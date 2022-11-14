<?php

session_start();
$user_id = $_SESSION["user_id"];
$user_level = $_SESSION["user_level"];

if(!isset($user_level) || $user_level == "Teacher") {
    header("Location: login.html");
    exit();
}

include_once("api/Database.php");
$db = new Database("localhost", "SchoolCitizenAssemblies", "mwd3iqjaesdr", "cPanMT3");
$connection = $db->get_connection();

$statement = $connection->prepare("
SELECT name, about, organisation, location, job_title, does_teacher_advice, does_project_work, does_student_online, does_student_f2f, does_student_resource, does_ks1, does_ks2, does_ks3, does_ks4, does_ks5
FROM Expert
WHERE user_id = :user_id;
");
$statement->bindValue(":user_id", $user_id, PDO::PARAM_INT);
$statement->execute();
$result = $statement->fetchAll();

$name = $result["name"];
$about = $result["about"];
$location = $result["location"];
$organisation = $result["organisation"];
$job_title = $result["job_title"];
$teacher_advice = boolval($result["does_teacher_advice"]);
$project_work = boolval($result["does_project_work"]);
$student_online = boolval($result["does_student_online"]);
$student_f2f = boolval($result["does_student_f2f"]);
$student_resource = boolval($result["does_student_resource"]);
$student_interactions = $student_f2f || $student_online || $student_resource;
$ks1 = boolval($result["does_ks1"]);
$ks2 = boolval($result["does_ks2"]);
$ks3 = boolval($result["does_ks3"]);
$ks4 = boolval($result["does_ks4"]);
$ks5 = boolval($result["does_ks5"]);

$statement = $connection->prepare("
SELECT *
FROM Expert_Resource
WHERE user_id = :user_id;
");
$statement->bindValue(":user_id", $user_id, PDO::PARAM_INT);
$statement->execute();
$result = $statement->fetchAll();

$resources = $result;

// expertise
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile - SCA</title>
        <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
        <link rel="stylesheet" href="css/expert-profile.css">
    </head>

    <body>
        <header>
            <h1><a href="home.html">School Citizen Assemblies</a></h1>

            <nav>
                <a href="about.html">About Us</a>
                <a>Teacher Resources</a>
                <a href="meet-the-experts.php">Meet The Experts</a>
            </nav>
        </header>

        <main>
            <div id="form-container">
                <form>

                    <div class="subform">
                        <h1>Personal Information</h1>

                        <div class="entry">
                            <div class="descriptor">
                                <label for="name">Name *</label>
                                <p>Your first and last name</p>
                            </div>

                            <input type="text" id="name" value=<?php "$name" ?>>
                        </div>

                        <hr>

                        <div class="entry">
                            <div class="descriptor">
                                <label for="about-them">About You *</label>
                                <p>A short description of you and your work</p>
                            </div>

                            <textarea id="about-them" name="about-them" spellcheck="true" value=<?php "$about" ?>></textarea>
                        </div>

                        <hr>

                        <div class="entry">
                            <div class="descriptor">
                                <label for="location">Location</label>
                                <p>First part of your postcode (e.g. SW6)</p>
                            </div>
                            
                            <input type="text" id="location" oninput="location_validity()" value=<?php "$location" ?>>
                        </div>

                        <hr>

                        <div class="entry">
                            <div class="descriptor">
                                <label for="expertise">Expertise *</label>
                                <p>Your areas of expertise in sustainability, biodiversity & climate change</p>
                            </div>
                            
                            <div id="expertises">
                                <input type="text" id="expertise">
                            </div>
                            
                        </div>

                        <hr>

                        <div class="entry">
                            <div class="descriptor">
                                <label for="organisation">Organisation</label>
                                <p>The organisation that you are currently a part of that is relevant to your expertise</p>
                            </div>
                            
                            <input type="text" id="organisation" value=<?php "$organisation" ?>>
                        </div>

                        <hr>

                        <div class="entry">
                            <div>
                                <label for="isEmployee">Employee</label>
                                <input type="radio" id="isEmployee" name="role" value="employee" onclick="job_title_visibility(this)" <?php if($job_title != "Volunteer") echo("checked");?>><br>
                                <label for="isVolunteer">Volunteer</label>
                                <input type="radio" id="isVolunteer" name="role" value="volunteer" onclick="job_title_visibility(this)" <?php if($job_title == "Volunteer") echo("checked");?>><br>
                            </div>
                            
                            <div id="job-title">
                                <div class="descriptor">
                                    <label for="job-title">Job Title</label>
                                    <p style="width: 95px">Your job title followed by your department</p>
                                </div>
                                <input type="text" id="job-title" value=<?php "$job_title"?>>
                            </div>
                            
                        </div>
                    </div>

                    <div class="subform">
                        <h1>Citizen Assemblies</h1>

                        <h2>Interactions</h2>
                        <div class="descriptor">
                            <p>The types of interactions you can do with different assemblies</p>
                        </div>

                        <div class="check-group">
                            <div>
                                <label for="teacher-advice">Teacher Advice</label>
                                <input id="teacher-advice" type="checkbox">
                            </div>

                            <div>
                                <label for="project-work">Project Work</label>
                                <input id="project-work" type="checkbox">
                            </div>

                            <div>
                                <label for="student-interactions">Student Interactions</label>
                                <input id="student-interactions" type="checkbox" onclick="student_interactions_visibility()">
                            </div>
                        </div>

                        <div class="check-group" id="student-interactions">
                            <div>
                                <label for="student-online">Online</label>
                                <input id="student-online" type="checkbox">
                            </div>

                            <div>
                                <label for="student-f2f">Face-to-Face</label>
                                <input id="student-f2f" type="checkbox">
                            </div>

                            <div>
                                <label for="student-resources">Resources</label>
                                <input id="student-resources" type="checkbox">
                            </div>
                        </div>

                        <hr>

                        <h2>Applicable Ages</h2>

                        <div class="descriptor">
                            <p>The ages that the above interactions are sutable for</p>
                        </div>

                        <div id="ages">
                            <label for="doesKS1">KS1</label>    <input type="checkbox" id="doesKS1">
                            <label for="doesKS2">KS2</label>    <input type="checkbox" id="doesKS2">
                            <label for="doesKS3">KS3</label>    <input type="checkbox" id="doesKS3">
                            <label for="doesKS4">KS4</label>    <input type="checkbox" id="doesKS4">
                            <label for="doesKS5">KS5</label>    <input type="checkbox" id="doesKS5">
                        </div>
                    </div>

                    <div class="subform">
                        <h1>Resources</h1>

                        <table id="resource-table">
                            <tr>
                                <td>Title</td>
                                <td>Link</td>
                                <td>Description</td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>Google</td>
                                <td>google.co.uk</td>
                                <td>A simple link to google</td>
                                <td><button type="Button" id="remove-resource-button" onclick="remove_resource(this)"><img src="assets/remove.png"></button></td>
                            </tr>
                        </table>

                        <button id="new-resource-button"><img src="assets/plus.png"></button>
                    </div>
                </form>
            </div> 
        </main>

        <dialog id="new-resource-dialog">
            <button id="close-dialog" onclick="document.querySelector('dialog#new-resource-dialog').close()">🠔</button>
            <h1>New Resource</h1>

            <form method="dialog">
                <label for="new-title">Title</label>
                <input type="text" id="new-title">
                <p>Title for your resource</p>

                <label for="new-link">Link</label>
                <input type="text" id="new-link">
                <p>A link to your resource</p>

                <label for="new-description">Description</label>
                <input type="text" id="new-description">
                <p>An optional description for your resource</p>

                <input type="submit" id="dialog-submit">
            </form>
        </dialog>

        <footer>
            <h1>School Citizen Assemblies</h1>

            <p>info@schoolcitizenassemblies.org</p>
        </footer>
    </body>

    <script>
        function location_validity() {
            const location_input = document.querySelector("#location");

            if(location_input.value == "" || valid_outcode(location_input.value)) {
                location_input.setCustomValidity('');
            } else {
                location_input.setCustomValidity("Invalid outcode format");
            }
            location_input.reportValidity();
        }

        function valid_outcode(outcode) {
            function generatePattern(string) {
                pattern = "";

                for (const char of string) {
                    if((/[a-zA-Z]/).test(char)) {
                        pattern += "A" // alphabetic
                    } else if((/[0-9]/).test(char)) {
                        pattern += "N" // numeric
                    } else {
                        pattern += "S" // symbol
                    }
                }

                return pattern;
            }

            validPatterns = [
                "AN",
                "ANN",
                "AAN",
                "AANN",
                "ANA",
                "AANA"
            ];
            outcode = outcode.toUpperCase();
            outcodePattern = generatePattern(outcode);

            return validPatterns.includes(outcodePattern);
        }

        function student_interactions_visibility() {
            const student_interactions_div = document.querySelector("div.check-group#student-interactions");

            if(student_interactions_div.style.display == "inline-block") {
                student_interactions_div.style.display = "none";
            } else {
                student_interactions_div.style.display = "inline-block";
            }
        }

        function job_title_visibility(element) {
            const job_title_div = document.querySelector("div#job-title");

            if(element.value == "employee") {
                job_title_div.style.display = "inline-block";
            } else {
                job_title_div.style.display = "none";
            }
        }

        document.querySelector('dialog#new-resource-dialog').addEventListener("close", (event) => { // on dialog close
            document.querySelector('dialog#new-resource-dialog #new-title').value = "";
            document.querySelector('dialog#new-resource-dialog #new-link').value = "";
            document.querySelector('dialog#new-resource-dialog #new-description').value = "";
        });

        document.querySelector("#new-resource-dialog").addEventListener("submit", (event) => { // submit dialog info
            event.preventDefault();
            const link_input = document.querySelector('dialog#new-resource-dialog #new-link');
            const title_input = document.querySelector('dialog#new-resource-dialog #new-title')

            const new_title = title_input.value;
            const new_link = link_input.value;
            const new_description = document.querySelector('dialog#new-resource-dialog #new-description').value;
            let isValid = true;

            link_valid(new_link)
            .then((link_validity) => {
                if(!link_validity) {
                    isValid = false;
                    link_input.setCustomValidity("This site is unreachable");
                    link_input.reportValidity();
                }

                if(new_title == "") {
                    isValid = false;
                    title_input.setCustomValidity("You must input a title");
                    title_input.reportValidity();
                }

                if(isValid) {
                    // add row to resource table
                    const remove_button_img = document.createElement("img");
                    const remove_button = document.createElement("button");
                    const title_cell = document.createElement("td");
                    const link_cell = document.createElement("td");
                    const description_cell = document.createElement("td");
                    const remove_button_cell = document.createElement("td")
                    const new_row = document.createElement("tr");

                    remove_button_img.setAttribute("src", "assets/remove.png");
                    remove_button.setAttribute("id", "remove-resource-button");
                    remove_button.setAttribute("type", "Button");
                    remove_button.setAttribute("onclick", "remove_resource(this)");
                    title_cell.textContent = new_title;
                    link_cell.textContent = new_link;
                    description_cell.textContent = new_description;

                    remove_button.appendChild(remove_button_img);
                    remove_button_cell.appendChild(remove_button);
                    new_row.appendChild(title_cell);
                    new_row.appendChild(link_cell);
                    new_row.appendChild(description_cell);
                    new_row.appendChild(remove_button_cell);

                    document.querySelector("#resource-table tbody").appendChild(new_row);

                    document.querySelector("#new-resource-dialog").close()
                }
            });
        });

        document.querySelector("#new-resource-button").addEventListener("click",  (event) => { // open dialog
            event.preventDefault();
            document.querySelector('#new-resource-dialog').showModal();
        });

        function remove_resource(element) {
            element.parentNode.parentNode.remove();
        }

        async function link_valid(url) {
            if(!url.startsWith("http://") || !url.startsWith("https://")) {
                url = "http://" + url;
            }

            /*fetch("phpScripts/url_status.php?"+url)
            .then((response) => response.text())
            .then((body) => {
                return body < 400 && 499 < body;
            });*/

            let response = await fetch("phpScripts/url_status.php?"+url);
            let body = await response.text();
            return body < 400 && 499 < body; 
        }

        document.querySelectorAll("#expertises input#expertise").forEach( (input) => {
            input.addEventListener("input", new_expertise_input);
        });
        
        function new_expertise_input() {
            const inputs = Array.from(document.querySelectorAll("#expertises input#expertise"));
            let counter = 0;

            for(const input of inputs) {
                if(input.value == "") {
                    if(inputs.indexOf(input) != inputs.length-1) {
                        input.remove();
                    }
                } else {
                    counter++;
                }
            }

            if(counter == inputs.length && inputs.length < 10) {
                const new_input = document.createElement("input");
                new_input.setAttribute("type", "text");
                new_input.setAttribute("id", "expertise");
                new_input.addEventListener("input", new_expertise_input);
                document.querySelector("div#expertises").appendChild(new_input);
            }
        }

        document.querySelector("div#form-container form").addEventListener("submit", (event) => {
            event.preventDefault();

            // check location validity


            return false;
        });
    </script>
</html>