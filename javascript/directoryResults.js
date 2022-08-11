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