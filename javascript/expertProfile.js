// validation on expertise
const expertiseInput = document.querySelector("input[name='expertise']");
expertiseInput.addEventListener("input", validateExpertiseInput);

function validateExpertiseInput(event) {
    // not null
    if(event.target.value == "") {
        // cannot be empty popup
        expertiseInput.style.borderColor = "red";
    } else {
        locationInput.style.borderColor = "#666666";
    }
}

// validation on organisation?
const orgInput = document.querySelector("input[name='company']");
orgInput.addEventListener("input", validateOrgInput);

function validateOrgInput(event) {
    
}

// validation on location
const locationInput = document.querySelector("input[name='location']");
locationInput.addEventListener("input", validateLocationInput);

function validateLocationInput(event) {
    if(!validPostcode(event.target.value) || event.target.value == "") {
        locationInput.style.borderColor = "red";
    } else {
        locationInput.style.borderColor = "#666666";
    }
}

function validPostcode(outcode) {
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

const saveButton = document.querySelector(".profile button");
saveButton.addEventListener("click", submit);

function submit() {
    inputs = document.querySelectorAll('input:not([name="studentInteraction"])');
    xhr = new XMLHttpRequest();
    formData = new FormData();

    formData.append("expertise", inputs[0].value);
    formData.append("org", inputs[1].value);
    formData.append("teacherAdvice", inputs[7].value == "on");
    formData.append("projectWork", inputs[8].value == "on");
    formData.append("studentOnline", inputs[9].value == "on");
    formData.append("studentF2F", inputs[10].value == "on");
    formData.append("studentResources", inputs[11].value == "on");
    formData.append("location", inputs[12].value);

    ages = "";
    for(i=2; i<7; i++) {
        if(inputs[i].value == "on") {
            if(i > 2) {
                ages += ",";
            }
            ages += "KS"+(i-1);
        }
    }
    formData.append("ages", ages);

    xhr.open("POST", "../phpScripts/updateExpert.php");
    xhr.send(formData);
}