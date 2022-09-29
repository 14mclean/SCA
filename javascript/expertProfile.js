class PostForm extends XMLHttpRequest {
    constructor() {
        super();
        this.form = new FormData();
    }

    append(name, value,) {
        this.form.append(name, value);
    }

    send(path) {
        super.open("POST", path);
        super.send(this.form);
    }
}

// ---------- HTML Element Constants ----------
const studentInteractionCheckbox = document.querySelector('input[name="studentInteraction"]');
const interactionLabels = [document.querySelector('label#online'), document.querySelector('label#f2f'), document.querySelector('label#resources')];
const interactionCheckboxes = [document.querySelector('input#online'), document.querySelector('input#f2f'), document.querySelector('input#resources')];
const locationInput = document.querySelector("input[name='location']");
const newResourceButton = document.querySelector(".addResource");
const resourcesTable = document.querySelector(".resourceTable");
const resourceLinkInputs = document.querySelectorAll('input[name="resourceLink"]');
const deleteImgs = document.querySelectorAll('img[src="assets/remove.png"]');
const saveButton = document.querySelector(".saveButton");
const form = document.querySelector(".profile");

// ---------- Event Listeners ----------
locationInput.addEventListener("input", validateLocationInput);
newResourceButton.addEventListener("click", addResource);
for(const linkInput of resourceLinkInputs) linkInput.addEventListener("input", checkResourceLink);
for(const img of deleteImgs) img.addEventListener("click", deleteResource);
for(const element of document.querySelectorAll('input[type="text"]')) element.addEventListener("input", buttonCheck);
for(const element of document.querySelectorAll('input[type="url"]')) element.addEventListener("input", buttonCheck);
form.addEventListener("submit", submit);

// ---------- Initial checks ----------
function init() {
    locationInput.dispatchEvent(new Event("input"));
    for(const linkInput of resourceLinkInputs) linkInput.dispatchEvent(new Event("input"));
    buttonCheck();
}

// ---------- Check for validity of inputs to disable or enable save button ----------
function buttonCheck() {
    var tmp = Array.from(document.querySelectorAll('input[type="text"]'));
    tmp.concat(Array.from(document.querySelectorAll('input[type="url"]')));

    for(const element of tmp) {
        if(!element.checkValidity()) {
            saveButton.disabled = true;
            return
        }
    }
    saveButton.disabled = false;
}

// ---------- Check validity of location input ----------
function validateLocationInput(event) {
    if(event.target.value == "") {
        locationInput.setCustomValidity('')
    } else if(!validPostcode(event.target.value)) {
        locationInput.setCustomValidity("Invalid outcode format");
    } else {
        locationInput.setCustomValidity('');
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

// ---------- Save contents of page then leave ----------
function submit(event) {
    event.preventDefault();
    inputs = document.querySelectorAll('input:not([name="studentInteraction"])');
    xhr = new XMLHttpRequest();
    formData = new FormData();

    formData.append("expertise", inputs[0].value);
    formData.append("org", inputs[1].value);
    formData.append("teacherAdvice", + inputs[7].checked);
    formData.append("projectWork", + inputs[8].checked);
    formData.append("studentOnline", + inputs[9].checked);
    formData.append("studentF2F", + inputs[10].checked);
    formData.append("studentResources", + inputs[11].checked);
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

    const nameInputs = document.querySelectorAll('input[name="resourceName"]');
    const linkInputs = document.querySelectorAll('input[name="resourceLink"]');

    nameInputs.forEach(element => element.value);
    linkInputs.forEach(element => element.value);

    var form = new PostForm();
    form.append("userID", userID);
    form.append("resourceNames", nameInputs);
    form.append("resourceLinks", linkInputs);
    form.send("../phpScripts/updateResource.php")

    /*xhr = new XMLHttpRequest();
    formData = new FormData();
    formData.append("resourceNames", nameInputs);
    formData.append("resourceLinks", linkInputs);
    xhr.open("POST", "../phpScripts/updateResource.php");
    xhr.send(formData);*/
    return false;
}

// ---------- Update whether specific student interactions can be seen ----------
function updateInteractionVisibilities() {
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


// ---------- Add new row to resources table ----------
function addResource() {
    // make table row
    const newRow = document.createElement("tr");

    // make table data
    const nameData = document.createElement("td");
    // make text input
    const nameInput = document.createElement("input");
    nameInput.setAttribute("type","text");
    nameInput.setAttribute("name", "resourceName");
    nameInput.setAttribute("required", "required");
    nameInput.setAttribute("placeholder", "Resource Name");
    // append input to data
    nameData.appendChild(nameInput);
    // append data to row
    newRow.appendChild(nameData)

    // make table data
    const linkData = document.createElement("td");
    // make text input
    const linkInput = document.createElement("input");
    linkInput.setAttribute("type","url");
    linkInput.setAttribute("name", "resourceLink");
    nameInput.setAttribute("required", "required");
    linkInput.setAttribute("placeholder", "Resource Link");
    linkInput.addEventListener("input", checkResourceLink);
    // append input to data
    linkData.appendChild(linkInput);
    // append data to row
    newRow.appendChild(linkData)

    // make table data
    const deleteData = document.createElement("td");
    // make text input
    const deleteImg = document.createElement("img");
    deleteImg.setAttribute("src", "assets/remove.png")
    deleteImg.addEventListener("click", deleteResource);
    // append input to data
    deleteData.appendChild(deleteImg);
    // append data to row
    newRow.appendChild(deleteData)

    // append row to table
    resourcesTable.appendChild(newRow);

    init();
}


// ---------- Delete resource row ----------
function deleteResource(event) {
    event.currentTarget.parentElement.parentElement.remove();
}

// ---------- Check if the provided resource link is valid ----------
function checkResourceLink(event) {
    url = event.currentTarget.value;
    newUrl = "";

    if(!url.startsWith("http://") || !url.startsWith("https://")) {
        newUrl += "http://"
    }

    if(!url.startsWith("www.")) {
        newUrl += "www.";
    }

    newUrl += url;

    target = event.path[0] || event.composedPath()[0];
    fetch("../phpScripts/getStatus.php?url="+url)
    .then(response => response.text())
    .then(linkStatus => {
        if(200 <= linkStatus && linkStatus <= 299) {
            target.setCustomValidity('');
            
        } else if (300 <= linkStatus && linkStatus <= 399) {
            target.setValidity({});
        } else if(399 < linkStatus) {
            target.setCustomValidity('Invalid URL');
        } else {
            target.setCustomValidity('');
        }
        buttonCheck();
    });
}

init();