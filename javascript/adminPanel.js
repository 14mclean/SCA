// ---------  approve expert ---------
const approveButtons = document.querySelectorAll("#unapprovedExperts table tbody tr:nth-child(n+1) td:nth-child(4)");
const unapprovedEmails = document.querySelectorAll("#unapprovedExperts table tbody tr:nth-child(n+1) td:nth-child(1)");

for(var i = 0; i < approveButtons.length; i++) {
    approveButtons[i].addEventListener("click", approveExpert, false);
    approveButtons[i].assocEmail = unapprovedEmails[i].textContent;
}

function approveExpert(event) {
    console.log("Approved '" + event.currentTarget.assocEmail + "'");
}


// ---------  add admin ---------