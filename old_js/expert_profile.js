document.querySelector(".profile").addEventListener("submit", submit);
document.querySelector(".addResource").addEventListener("click", add_resource);
document.querySelector("input[name='location']").addEventListener("input", validate_location_input);

//for(const linkInput of resourceLinkInputs) linkInput.addEventListener("input", checkResourceLink);
for(const img of document.querySelectorAll('img[src="assets/remove.png"]')) img.addEventListener("click", delete_resource);
//for(const element of document.querySelectorAll('input[type="text"]')) element.addEventListener("input", buttonCheck);
//for(const element of document.querySelectorAll('input[type="url"]')) element.addEventListener("input", buttonCheck);

// ---------- Update whether specific student interactions can be seen ----------
function update_interaction_visibilities() {
    const student_interaction_checkbox = document.querySelector('input[name="studentInteraction"]');
    const interaction_labels = [document.querySelector('label#online'), document.querySelector('label#f2f'), document.querySelector('label#resources')];
    const interaction_checkboxes = [document.querySelector('input#online'), document.querySelector('input#f2f'), document.querySelector('input#resources')];


    for(let i = 0; i < 3; i++) {
        checkbox = interaction_checkboxes[i];
        label = interaction_labels[i];

        checkbox.checked = false; // uncheck each interaction type

        if(student_interaction_checkbox.checked) { // let interaction type be seen
            checkbox.style.display = "initial";
            label.style.display = "initial";
        } else { // stops interaction type from being seen
            checkbox.style.display = "none";
            label.style.display = "none";
        } 
    }  
}


// ---------- Check validity of location input ----------
function validate_location_input(event) {
    if(event.target.value == "") {
        locationInput.setCustomValidity('')
    } else if(!validPostcode(event.target.value)) {
        locationInput.setCustomValidity("Invalid outcode format");
    } else {
        locationInput.setCustomValidity('');
    }
}

function valid_postcode(outcode) {
    function generatePattern(string) {
        pattern = "";

        for (const char of string) {
            if((/[a-zA-Z]/).test(char)) {
                pattern += "A"
            } else if((/[0-9]/).test(char)) {
                pattern += "N"
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

    return validPatterns.includes(outcodePattern)
}


// ---------- Add new row to resources table ----------
function add_resource() {
    // make table row
    const new_row = document.createElement("tr");

    // make table data
    const name_data = document.createElement("td");
    // make text input
    const name_input = document.createElement("input");
    name_input.setAttribute("type","text");
    name_input.setAttribute("name", "resourceName");
    name_input.setAttribute("required", "required");
    name_input.setAttribute("placeholder", "Resource Name");
    // append input to data
    name_data.appendChild(name_input);
    // append data to row
    new_row.appendChild(name_data)

    // make table data
    const link_data = document.createElement("td");
    // make text input
    const linkInput = document.createElement("input");
    linkInput.setAttribute("type","url");
    linkInput.setAttribute("name", "resourceLink");
    name_input.setAttribute("required", "required");
    linkInput.setAttribute("placeholder", "Resource Link");
    //linkInput.addEventListener("input", checkResourceLink); TODO:
    // append input to data
    link_data.appendChild(linkInput);
    // append data to row
    new_row.appendChild(link_data)

    // make table data
    const delete_data = document.createElement("td");
    // make text input
    const delete_img = document.createElement("img");
    delete_img.setAttribute("src", "assets/remove.png")
    delete_img.addEventListener("click", delete_resource);
    // append input to data
    delete_data.appendChild(delete_img);
    // append data to row
    new_row.appendChild(delete_data)

    // append row to table
    resourcesTable.appendChild(new_row);
}


// ---------- Check if the provided resource link is valid ----------



// ---------- Delete resource row ----------
function delete_resource(event) {
    event.currentTarget.parentElement.parentElement.remove();
}


// ---------- Save contents of page then leave ----------
function submit(event) {
    event.preventDefault();

    let current_resources = [];
    const nameInputs = document.querySelectorAll('input[name="resourceName"]');
    const linkInputs = document.querySelectorAll('input[name="resourceLink"]');

    for(let i=0; i< linkInputs.length; i++) {
        current_resources.push({
            "userID": userID,
            "name": nameInputs[i],
            "link": linkInputs[i]
        });
    }
    
    // Update expert info
    fetch("/api/experts/"+userID, {
        method: 'PATCH',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            "organisation": document.querySelector('input[name="organisation"]').value, // get data
            "ages": "",
            "expertise": document.querySelector('input[name="expertise"]').value,
            "teacherAdvice": +document.querySelector('#teacherAdvice').checked,
            "projectWork": +document.querySelector('#projectWork').checked,
            "studentOnline": +document.querySelector('').checked,
            "studentF2F": +document.querySelector('').checked,      // selectors??
            "studentResources": +document.querySelector('').checked,
            "location": document.querySelector('input[name="location"]').value
        })
    })
    .then((response) => {
        if(!response.ok) {
            throw new Error('Server error ' + response.status);
        } 
    });

    // Update resources associated with the expert
    fetch("/api/expertresources")
    .then((response) => {
        if(response.ok) {
            return response.json();
        } else {
            throw new Error('Server error ' + response.status);
        }
    })
    .then(json => {
        let old_resources = [];

        for(const row of json) {
            if(row["userID"] == userID) {
                old_resources.push(row);
            }
        }

        for(const old_resource of old_resources) {
            for(const new_resource of current_resources) {
                if(new_resource["name"] == old_resource["name"] && new_resource["link"] == old_resource["link"]) {
                    current_resources = remove_item_from_array(current_resources, old_resource);
                } else {
                    fetch("/api/expertresources/"+old_resource["resourceID"], {
                        method: 'DELETE',
                        headers: {'Content-Type': 'application/json'}
                    })
                    .then((response) => {
                        if(!response.ok) {
                            throw new Error('Server error ' + response.status);
                        } 
                    });
                }
            }
        }

        for(const resource of current_resources) {
            fetch("/api/expertresources", {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    "userID": userID,
                    "name": resource["name"],
                    "link": resource["link"]
                })
            })
            .then((response) => {
                if(!response.ok) {
                    throw new Error('Server error ' + response.status);
                } 
            });
        }  
    });
}

function remove_item_from_array(array, item) {
    const index = array.indexOf(item);
    if (index > -1) { // only splice array when item is found
        array.splice(index, 1);
    }
    return array;
}