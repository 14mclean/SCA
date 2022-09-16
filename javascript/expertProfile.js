function init() {
    locationInput.dispatchEvent(new Event("input"));
    expertiseInput.dispatchEvent(new Event("input"));
    //studentInteractionCheckbox.dispatchEvent(new Event(""));
}

// validation on expertise
const expertiseInput = document.querySelector("input[name='expertise']");
expertiseInput.addEventListener("input", validateExpertiseInput);

function validateExpertiseInput(event) {
    // not null
    if(event.target.value == "") {
        expertiseInput.style.borderColor = "red";
        // disable save button
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
    if(!validPostcode(event.target.value)) {
        locationInput.style.borderColor = "red";
        // disable save button
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
    // if disabled return

    inputs = document.querySelectorAll('input:not([name="studentInteraction"])');
    xhr = new XMLHttpRequest();
    formData = new FormData();

    formData.append("expertise", inputs[0].value);
    formData.append("org", inputs[1].value);
    formData.append("teacherAdvice", inputs[7].checked);
    formData.append("projectWork", inputs[8].checked);
    formData.append("studentOnline", inputs[9].checked);
    formData.append("studentF2F", inputs[10].checked);
    formData.append("studentResources", inputs[11].checked);
    formData.append("location", inputs[12].value);

    ages = "";
    for(i=2; i<7; i++) {
        if(inputs[i].checked) {
            if(i > 2) {
                ages += ",";
            }
            ages += "KS"+(i-1);
        }
    }
    formData.append("ages", ages);

    xhr.open("POST", "../phpScripts/updateExpert.php");
    xhr.send(formData);

    // foward to mte
}

const studentInteractionCheckbox = document.querySelector('input[name="studentInteraction"]');
//studentInteractionCheckbox.addEventListener("", );

function updateInteractionVisibilities(event) {
    // if student interaction not checked
        //  uncheck all interactions
        // hide interactions
    // else
        // show interactions
}

init();