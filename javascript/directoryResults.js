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
    input.addEventListener("input", updateResults);
}

for(const input of checkboxInputs) {
    input.addEventListener("click", updateResults);
}

for(const input of rangeInputs) {
    input.addEventListener("dragend", updateResults); //mouseup ?
}

function updateResults() {
    var getFilter = "adminVerified=1";
    var ages = [];
    var organisations = [];
    var outcode = "";
    const maxRange = rangeInputs[0].value;

    for(const input of checkboxInputs) {
        if(input.checked) {
            if(input.name.includes("age")) {
                ages.push("ks"+input.name[3]);
            } else if(input.name == "teacherAdvice" || input.name == "projectWork" || input.name == "studentOnline" || input.name == "studentResources" || input.name == "studentOnline") {
                getFilter += "&" + input.name + "=1";
            } else if(input.name != "studentInteraction") {
                organisations.push(input.name);
            }
        } 
    }

    if(ages.length > 0) {
        getFilter += "&ages=" + ages.toString();
    }

    if(organisations.length > 0) {
        getFilter += "&orgs=" + organisations.toString();
    }

    for(const input of textInputs) {
        switch(input.name) {
            case "expertise":
                getFilter += "&expertise=" + input.value;
            case "outcode":
                outcode = input.value;
        }
    }

    fetch("../phpScripts/getResults.php?"+getFilter)
    .then(response => response.json())
    .then(data => {
        console.log(data)

        // google api for distance

        // if fits distance

        const newResult = document.createElement("div");
        newResult.setAttribute("class", "item");
        const text = document.createTextNode(data)
        newResult.appendChild(text);
        document.querySelector(".results").appendChild(newResult);
    });
}