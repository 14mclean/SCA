function init() {
    locationInput.dispatchEvent(new Event("input"));
    expertiseInput.dispatchEvent(new Event("input"));
    studentInteractionCheckbox.dispatchEvent(new Event("click"));
}

var isExpertiseValid = false;
var isLocationValid = false;
const saveButton = document.querySelector(".profile button");

function buttonCheck() {
    saveButton.disabled = !(isExpertiseValid && isLocationValid)
}

// validation on expertise
const expertiseInput = document.querySelector("input[name='expertise']");
expertiseInput.addEventListener("input", validateExpertiseInput);

function validateExpertiseInput(event) {
    // not null
    if(event.target.value == '') {
        expertiseInput.style.borderColor = "red";
        isExpertiseValid = false;
    } else {
        locationInput.style.borderColor = "#666666";
        isExpertiseValid = true;
    }
    buttonCheck()
}

// validation on location
const locationInput = document.querySelector("input[name='location']");
locationInput.addEventListener("input", validateLocationInput);

function validateLocationInput(event) {
    if(!validPostcode(event.target.value)) {
        locationInput.style.borderColor = "red";
        isLocationValid = false;
    } else {
        locationInput.style.borderColor = "#666666";
        isLocationValid = true;
    }
    buttonCheck()
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
const interactionCheckboxes = [
    document.querySelector('input#online'),
    document.querySelector('input#f2f'),
    document.querySelector('input#resources')
];
const interactionLabels = [
    document.querySelector('label#online'),
    document.querySelector('label#f2f'),
    document.querySelector('label#resources')
];
studentInteractionCheckbox.addEventListener("click", updateInteractionVisibilities);

function updateInteractionVisibilities(event) {
    for(let i = 0; i < 3; i++) {
        checkbox = interactionCheckboxes[i];
        label = interactionLabels[i];

        checkbox.checked = false;

        if(studentInteractionCheckbox.checked) {
            checkbox.style.display = "initial";
            label.style.display = "initial";
        } else {
            checkbox.style.display = "none";
            label.style.display = "none";
        } 
    }  
}

init();