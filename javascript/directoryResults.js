// ---------  expand hidden filters ---------

const studentInteractionCheckbox = document.querySelector("#studentInteractionCheck");
const studentInteractionDiv = document.querySelector("#studentInteractions");

studentInteractionDiv.style.display = "none";
studentInteractionCheckbox.addEventListener("click", expandStudentInteraction);

function expandStudentInteraction() {
    if(studentInteractionDiv.style.display == "none") {
        studentInteractionDiv.style.display = "initial";
    } else {
        studentInteractionDiv.style.display = "none";
        // TODO: uncheck interaction boxes
    }
}

// ---------  Tick checkboxes when label clicked ---------

const filterLabels = document.querySelectorAll(".refine label");

for(const label of filterLabels) {
    label.addEventListener("click", checkBox);
    label.label = label;
}

function checkBox() {
    this.previousElementSibling.click();
}

// ---------  Update distance value on slider ---------

const slider = document.querySelector('input[type="range"]');
const output = document.querySelector("#distanceDisplay");

output.innerHTML = slider.value;

slider.oninput = function() {
    output.innerHTML = this.value;
}

// ---------  Update results ---------
const textInputs = document.querySelectorAll('input[type="text"]');
const checkboxInputs = document.querySelectorAll('input[type="checkbox"]');
const rangeInputs = document.querySelectorAll('input[type="range"]');

for(const input of textInputs) {
    input.addEventListener("input", update_results);
}

for(const input of checkboxInputs) {
    input.addEventListener("click", update_results);
}

for(const input of rangeInputs) {
    input.addEventListener("dragend", update_results); //mouseup ?
}

function update_results() {
    // clear current results
    document.querySelector(".results").textContent = '';

    let organisations = [];
    let ages = [];
    let interactions = {};

    for(const input of checkboxInputs) {
        if(input.name.includes("age")) {
            if(input.checked) {
                ages.push("ks"+input.name[3]);
            }
        } else if(input.name == "teacherAdvice" || input.name == "projectWork" || input.name == "studentOnline" || input.name == "studentResources" || input.name == "studentOnline") {
            interactions[input.name] = input.checked;
        } else if(input.name != "studentInteraction" && input.checked) {
            organisations.push(input.name);
        }
    }

    fetch("/api/users")
    .then((response) => response.json())
    .then(json => {
        for(const row of json) {
            if(
                (interactions["teacherAdvice"] && row["teacherAdvice"] == 0) || // does teacher advice, if checked
                (interactions["projectWork"] && row["projectWork"] == 0) || // does project work, if checked
                (interactions["studentOnline"] && row["studentOnline"] == 0) || // does student online, if checked 
                (interactions["studentF2F"] && row["studentF2F"] == 0) || // does student f2f, if checked 
                (interactions["studentResources"] && row["studentResources"] == 0) || // does student resources, if checked 
                row["adminVerified"] != 1 || // ensures expert is verified
                (!organisations.includes(row["organisation"]) && organisations.length > 0) // if one of the checked organisations
            ) {
                continue
            }

            // caters to all of the checked ages
            for(const age in row["ages"]) {
                if(!ages.includes(ages) && ages.length > 0) {
                    continue;
                }
            }

            add_expert(row["userID"], row["location"]);
        }
    })
}

function add_expert(userID, location) {
    // google api for distance
    const distance = 0;
    
    if(distance < rangeInputs[0].value) {
        const new_result = document.createElement("div");
        new_result.setAttribute("class","item");

        fetch("/api/expertresources")
        .then(response => response.json())
        .then(json => {
            for(const row of json) {
                if(row["userID"] == userID) {
                    const new_link = document.createElement("a");
                    new_link.setAttribute("href", row["link"]);
                    new_link.appendChild(document.createTextNode(row["name"]))
                    new_result.appendChild(new_link);
                }
            }
        });
        document.querySelector(".results").appendChild(new_result);
    }
}