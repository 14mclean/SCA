// ---------  approve expert ---------
const approveButtons = document.querySelector("#unapprovedExperts table tbody tr:nth-child(n+1) td:nth-child(4)");

for(const button of approveButtons) {
    button.addEventListener("click", approveExpert);
}

function approveExpert() {
    console.log("Approved");
}


// ---------  add admin ---------