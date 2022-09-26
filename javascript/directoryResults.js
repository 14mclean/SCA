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
    var getFilter = "adminVerified=1"; // a=b&c=d

    for(const input of textInputs) {
        getFilter += "&" + input.name + "=" + input.value;
    }

    for(const input of rangeInputs) {
        getFilter += "&" + input.name + "=" + input.value;
    }

    for(const input of textInputs) {
        if(input.checked) {
            getFilter += "&" + input.name + "=1";
        }
        
    }

    /* 

    organisation = org1 OR org2 ...

    ages: includes 'ks1','ks2'...

    expertise: SOUNDEX(expertise)

    if teacherAdvice is checked
        teacherAdvice = 1

    if projectWork is checked
        projectWork = 1

    if studentOnline is checked
        studentOnline = 1

    if studentF2F is checked
        studentF2F = 1

    if studentResources is checked
        projectWork = 1

    location (none sql)
        distance/time < range

    */
    
    fetch("../phpScripts/getResults.php?"+getFilter).then(result => console.log(result.body));

    //const response = await fetch("../phpScripts/getResults.php?"+getFilter);
    //console.log(response.text());
}