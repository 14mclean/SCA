// validation on expertise
const expertiseInput = document.querySelector("input[name='expertise']");
expertiseInput.addEventListener("input", validateExpertiseInput);

function validateExpertiseInput(event) {
    // not null
    if(event.target.value == "") {
        // cannot be empty popup
        expertiseInput.style.borderColor = "red";
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
    $inputText = event.target.value;

    // fits postcode format: 2-4 chars, starts with letter
    if(inputText.length < 2 || inputText.length > 4 || !inputText[0].match(/[a-z]/i)) {
        locationInput.style.borderColor = "red";
    }
}
