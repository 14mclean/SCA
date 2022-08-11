// ---------  expand hidden filters ---------

const studentInteractionCheckbox = document.querySelector("#studentInteractionCheck");
const studentInteractionDiv = document.querySelector("#studentInteractions");

studentInteractionCheckbox.addEventListener("click", expandStudentInteraction);

function expandStudentInteraction() {
    if(studentInteractionDiv.style.display == "none") {
        studentInteractionDiv.style.display = "initial";
        studentInteractionDiv.style.opacity = "1";
    } else {
        studentInteractionDiv.style.opacity = "0";
        studentInteractionDiv.style.display = "none";
    }
}

// ---------  Tick checkboxes when label clicked ---------

const filterLabels = document.querySelectorAll(".inputs label");

for(const label of filterLabels) {
    label.addEventListener("click", checkBox);
    label.label = label;
}

function checkBox() {
    this.previousElementSibling.click();
}