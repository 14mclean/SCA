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

    for(const input of checkboxInputs) {
        if(input.checked) {
            getFilter += "&" + input.name + "=1";
        }
        
    }
    
    fetch("../phpScripts/getResults.php?"+getFilter)
    .then(response => response.text())
    .then(data => console.log(data));
}