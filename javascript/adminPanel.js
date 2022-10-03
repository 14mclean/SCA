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

// ----- HTML ELements -----
const approveExpertButtons = document.querySelectorAll();
const blockEmailButtons = document.querySelectorAll();
const newAdminButton = document.querySelector();
const removeAdminButtons = document.querySelectorAll();
const unapprovedEmails = document.querySelectorAll();


// ----- Event Listeners -----


// ----- Approve expert -----
for(var i = 0; i < approveButtons.length; i++) {
    approveButtons[i].associatedEmail = unapprovedEmails[i].textContent;
}

function approveExpert(event) {
    form = new PostForm();
    form.append("email", event.currentTarget.associatedEmail);
    form.send("../phpScripts/approveExpert.php");
    // refresh page
}

function removeAdmin(event) {
    form = new PostForm();
    form.append("email", event.currentTarget.associatedEmail);
    form.send("../phpScripts/approveExpert.php");
    // refresh page
}