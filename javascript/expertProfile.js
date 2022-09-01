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
    // get all values
    inputs = document.querySelectorAll('input:not([name="studentInteraction"])');
    // format results
    // add 
    console.log(inputs);

    xhr = new XMLHttpRequest();
    formData = new FormData();
}