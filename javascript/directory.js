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