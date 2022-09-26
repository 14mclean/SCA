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
inputs = document.querySelectorAll("input");

for(const input of inputs) {
    input.addEventListener("", updateResults);
}

function updateResults() {
    
}