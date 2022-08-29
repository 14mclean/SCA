// --------- approve expert ---------
const approveButtons = document.querySelectorAll("#unapprovedExperts table tbody tr:nth-child(n+1) td:nth-child(4)");
const unapprovedEmails = document.querySelectorAll("#unapprovedExperts table tbody tr:nth-child(n+1) td:nth-child(1)");

for(var i = 0; i < approveButtons.length; i++) {
    approveButtons[i].addEventListener("click", approveExpert, false);
    approveButtons[i].assocEmail = unapprovedEmails[i].textContent;
}

function approveExpert(event) {
    console.log("Approved " + event.currentTarget.assocEmail);
}

// --------- block expert ---------
const blockButtons = document.querySelectorAll("#unapprovedExperts table tbody tr:nth-child(n+1) td:nth-child(5)");

for(var i = 0; i < blockButtons.length; i++) {
    blockButtons[i].addEventListener("click", blockExpert, false);
    blockButtons[i].assocEmail = unapprovedEmails[i].textContent;
}

function blockExpert(event) {
    console.log("Blocked " + event.currentTarget.assocEmail);
}


// --------- add admin ---------
const addAdminButton = document.querySelector("#admins div button");

addAdminButton.addEventListener("click", addAdmin, false);

function addAdmin() {
    console.log("Add admin");
}

// --------- remove admin ---------
const removeAdminButtons = document.querySelectorAll("#admins table tbody tr td:nth-child(2) button");
const adminEmails = document.querySelectorAll("#admins table tbody tr td:nth-child(1)");

for(var i = 0; i < removeAdminButtons.length; i++) {
    removeAdminButtons[i].addEventListener("click", removeAdmin, false);
    removeAdminButtons[i].assocEmail = adminEmails[i].textContent;
}

function removeAdmin(event) {
    console.log("Remove admin " + event.currentTarget.assocEmail)
}