<?php

session_start();
if(isset($_SESSION["user_id"])) {
    $logged_in = true;
    $user_level = $_SESSION["user_level"];
    $user_id = $_SESSION["user_id"];
} else {
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
$result = $statement->fetchAll()[0];

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

// resources
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
$statement = $connection->prepare("
SELECT *
FROM Expertise
WHERE user_id = :user_id;
");
$statement->bindValue(":user_id", $user_id, PDO::PARAM_INT);
$statement->execute();
$result = $statement->fetchAll();
$expertise = $result;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile - SCA</title>
        <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
        <link rel="stylesheet" href="css/template.css">
        <link rel="stylesheet" href="css/expert-profile.css">
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
            <div id="form-container">
                <form>

                    <button class="save-button">Save</button>

                    <div class="subform">
                        <h1>Personal Information</h1>

                        <div class="entry">
                            <div class="descriptor">
                                <label for="name">Name *</label>
                                <p>Your first and last name</p>
                            </div>

                            <input type="text" id="name" value="<?php echo($name) ?>">
                        </div>

                        <hr>

                        <div class="entry">
                            <div class="descriptor">
                                <label for="about-them">About You *</label>
                                <p>A short description of you and your work</p>
                            </div>

                            <textarea id="about-them" name="about-them" spellcheck="true"><?php echo($about) ?></textarea>
                        </div>

                        <hr>

                        <div class="entry">
                            <div class="descriptor">
                                <label for="location">Location</label>
                                <p>First part of your postcode (e.g. SW6)</p>
                            </div>
                            
                            <input type="text" id="location" value="<?php echo($location) ?>">
                        </div>

                        <hr>

                        <div class="entry">
                            <div class="descriptor">
                                <label for="expertise">Expertise *</label>
                                <p>Your areas of expertise in sustainability, biodiversity & climate change</p>
                            </div>
                            
                            <div id="expertises">
                                <?php
                                    foreach($expertise as $expertise_instance) {
                                        $expertise_name = $expertise_instance["expertise"];
                                        echo("
                                        <input type=\"text\" id=\"expertise\" value=\"$expertise_name\"></input>
                                        ");
                                    }
                                ?>


                                <input type="text" id="expertise">
                            </div>
                            
                        </div>

                        <hr>

                        <div class="entry">
                            <div class="descriptor">
                                <label for="organisation">Organisation</label>
                                <p>The organisation that you are currently a part of that is relevant to your expertise</p>
                            </div>
                            
                            <input type="text" id="organisation" value="<?php echo($organisation) ?>">
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
                                <input type="text" id="job-title" value="<?php echo($job_title) ?>">
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
                                <input id="teacher-advice" type="checkbox" <?php if($teacher_advice) echo("checked"); ?>>
                            </div>

                            <div>
                                <label for="project-work">Project Work</label>
                                <input id="project-work" type="checkbox" <?php if($project_work) echo("checked"); ?>>
                            </div>

                            <div>
                                <label for="student-interactions">Student Interactions</label>
                                <input id="student-interactions" type="checkbox" onclick="student_interactions_visibility()" <?php if($student_interactions) echo("checked"); ?>>
                            </div>
                        </div>

                        <div class="check-group" id="student-interactions">
                            <div>
                                <label for="student-online">Online</label>
                                <input id="student-online" type="checkbox" <?php if($student_online) echo("checked"); ?>>
                            </div>

                            <div>
                                <label for="student-f2f">Face-to-Face</label>
                                <input id="student-f2f" type="checkbox" <?php if($student_f2f) echo("checked"); ?>>
                            </div>

                            <div>
                                <label for="student-resources">Resources</label>
                                <input id="student-resources" type="checkbox" <?php if($student_resource) echo("checked"); ?>>
                            </div>
                        </div>

                        <hr>

                        <h2>Applicable Ages</h2>

                        <div class="descriptor">
                            <p>The ages that the above interactions are sutable for</p>
                        </div>

                        <div id="ages">
                            <label for="doesKS1">KS1</label>    <input type="checkbox" id="doesKS1" <?php if($ks1) echo("checked"); ?>>
                            <label for="doesKS2">KS2</label>    <input type="checkbox" id="doesKS2" <?php if($ks2) echo("checked"); ?>>
                            <label for="doesKS3">KS3</label>    <input type="checkbox" id="doesKS3" <?php if($ks3) echo("checked"); ?>>
                            <label for="doesKS4">KS4</label>    <input type="checkbox" id="doesKS4" <?php if($ks4) echo("checked"); ?>>
                            <label for="doesKS5">KS5</label>    <input type="checkbox" id="doesKS5" <?php if($ks5) echo("checked"); ?>>
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

                            <?php

                            foreach($resources as $resource) {
                                $title = $resource["name"];
                                $link = $resource["link"];
                                $desc = $resource["description"];

                                echo("
                                <tr>
                                    <td>$title</td>
                                    <td>$link</td>
                                    <td>$desc</td>
                                    <td><button type='Button' id='remove-resource-button' onclick='remove_resource(this)'><img src='assets/remove.png'></button></td>
                                </tr>
                                ");
                            }

                            ?>
                        </table>

                        <button id="new-resource-button"><img src="assets/plus.png"></button>
                    </div>

                    <button class="save-button">Save</button>
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
            <h2>© School Citizen Assemblies</h2>

            <p>support@schoolcitizenassemblies.org</p>
        </footer>

        <script src="javascript/header.js"></script>
        <script>
            function debounce(callback, wait) {
                let timeout;
                return (...args) => {
                    clearTimeout(timeout);
                    timeout = setTimeout(function () { callback.apply(this, args); }, wait);
                };
            }

            document.querySelector("input#location").addEventListener("keyup", debounce(() => { // validate password 1s after typing concludes
                const location_input = document.querySelector("#location");

                if(location_input.value == "" || valid_outcode(location_input.value)) {
                    location_input.setCustomValidity('');
                } else {
                    location_input.setCustomValidity("Invalid outcode format");
                }
                location_input.reportValidity();
            }, 1000));

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

            document.querySelector("div#form-container form").addEventListener("submit", (event) => { // submit data
                event.preventDefault();

                const name = document.getElementById("name").value,
                about = document.getElementById("about-them").value,
                location = document.getElementById("location").value,
                organisation = document.getElementById("organisation").value,
                job_title = (document.getElementById("isVolunteer").checked) ? "Volunteer":document.getElementById("job-title").value,
                teacher_advice = +document.getElementById("teacher-advice").checked,
                project_work = +document.getElementById("project-work").checked,
                student_online = +(document.getElementById("student-online").checked && document.getElementById("student-interactions").checked),
                student_f2f = +(document.getElementById("student-f2f").checked && document.getElementById("student-interactions").checked),
                student_resources = +(document.getElementById("student-resources").checked && document.getElementById("student-interactions").checked),
                ks1 = +document.getElementById("doesKS1").checked,
                ks2 = +document.getElementById("doesKS2").checked,
                ks3 = +document.getElementById("doesKS3").checked,
                ks4 = +document.getElementById("doesKS4").checked,
                ks5 = +document.getElementById("doesKS5").checked;
                

                let new_resources = [],
                    new_expertise = [];

                for(const row of document.querySelectorAll("#resource-table tbody tr:not(:first-child)")) {
                    const name = row.children[0].textContent;
                    const link = row.children[1].textContent;
                    const description = row.children[2].textContent;

                    new_resources.push({"name": name, "link": link, "description": description, "user_id":user_id});
                }

                for(const input of document.querySelectorAll("#expertises input")) {
                    new_expertise.push(input.value);
                }

                // get user's current resources
                fetch("/api/expertresources?filter=" + btoa(JSON.stringify({"user_id":{"operator":"", "value": [user_id]}})))
                .then(response => {
                    if(response.ok) {
                        return response.json();
                    }
                })
                .then(old_resources => {
                    function resource_array_includes(array, resource) {
                        function resource_equality(resource1, resource2) {
                            return
                                resource1["user_id"] == resource2["user_id"] &&
                                resource1["name"] == resource2["name"] &&
                                resource1["link"] == resource2["link"] &&
                                resource1["description"] == resource2["description"];
                        }

                        for(const element of array) {
                            if(resource_equality(element, resource)) return true;
                        }
                        return false
                    }
                    
                    // foreach all_resources
                        // if in old, not new
                            // delete
                        // if in new, not old
                            // post

                    for(const resource of old_resources.concat(new_resources)) {
                        let in_new = resource_array_includes(new_resources, resource),
                            in_old = resource_array_includes(old_resources, resource);

                        if(in_old && !in_new) {
                            fetch("/api/expertresources/"+resource["resource_id"], {
                                method: "DELETE",
                                headers: {'Content-Type': 'application/json'}
                            })
                        } else if(in_new && !in_old) {
                            fetch("/api/expertresources", {
                                method: "POST",
                                headers: {'Content-Type': 'application/json'},
                                body: JSON.stringify({
                                    "user_id": user_id,
                                    "name": resource["name"],
                                    "link": resource["link"],
                                    "description": resource["description"],
                                })
                            })
                        }
                    }
                });

                // get user's current expertise
                fetch("/api/expertise?filter=" + btoa(JSON.stringify({"user_id":{"operator":"", "value": [user_id]}})))
                .then(response => {
                    if(response.ok) {
                        return response.json();
                    }
                })
                .then(old_expertise => {
                    function expertise_array_includes(array, expertise) {
                        function expertise_equality(expertise1, expertise2) {
                            return
                                expertise1["user_id"] == expertise2["user_id"] &&
                                expertise1["expertise"] == expertise2["name"];
                        }

                        for(const element of array) {
                            if(expertise_equality(element, expertise)) return true;
                        }
                        return false
                    }
                    
                    // foreach all_expertise
                        // if in old, not new
                            // delete
                        // if in new, not old
                            // post

                    for(const expertise of old_expertise.concat(new_expertise)) {
                        let in_new = expertise_array_includes(new_expertise, expertise),
                            in_old = expertise_array_includes(old_expertise, expertise);

                        if(in_old && !in_new) {
                            fetch("/api/expertise/"+expertise["expertise_instance_id"], {
                                method: "DELETE",
                                headers: {'Content-Type': 'application/json'}
                            })
                        } else if(in_new && !in_old) {
                            fetch("/api/expertise", {
                                method: "POST",
                                headers: {'Content-Type': 'application/json'},
                                body: JSON.stringify({
                                    "user_id": user_id,
                                    "expertise": expertise["expertise"]
                                })
                            })
                        }
                    }
                });
                
                // send patch request for user details
                fetch("/api/experts/"+user_id, {
                    method: "PATCH",
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        "name": name,
                        "about": about,
                        "organisation": organisation,
                        "location": location,
                        "job_title": job_title,
                        "does_teacher_advice": teacher_advice,
                        "does_project_work": project_work,
                        "does_student_online": student_online,
                        "does_student_f2f": student_f2f,
                        "does_student_resource": student_resources,
                        "does_ks1": ks1,
                        "does_ks2": ks2,
                        "does_ks3": ks3,
                        "does_ks4": ks4,
                        "does_ks5": ks5
                    })
                });

                window.location.href = "directory.php";
            });



            function init() {
                student_interactions_visibility();
                
                if("<?php echo($job_title) ?>" == "Volunteer") {
                    job_title_visibility(
                        document.querySelector("#isVolunteer")
                    );
                } else {
                    job_title_visibility(
                        document.querySelector("#isEmployee")
                    );
                }   
            }

            init();
            const user_id = <?php echo($user_id) ?>;
        </script>
    </body>
</html>