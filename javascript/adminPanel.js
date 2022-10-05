// ----- HTML ELements -----
const approve_expert_buttons = document.querySelectorAll(".approveButton");
const block_email_buttons = document.querySelectorAll(".blockButton");
const new_admin_button = document.querySelector(".newAdminButton");
const remove_admin_buttons = document.querySelectorAll(".demoteAdminButton");


// ----- Event Listeners -----
for(const button of approve_expert_buttons) {
    button.addEventListener("click", approve_expert);
}

for(const button of remove_admin_buttons) {
    button.addEventListener("click", remove_admin);
}


// ----- Approve expert -----
function approve_expert(event) {
    data = {"adminApproved": 1};
    API.api_request("experts/"+event.currentTarget.id, API_METHOD_PATCH, JSON.stringify(data));
    location.reload();
}


// ----- Demote Admin -----
function remove_admin(event) {
    data = {"userLevel": "Teacher"};
    API.api_request("users/"+event.currentTarget.id, API_METHOD_PATCH, JSON.stringify(data));
    location.reload();
}


// ----- Block E-Mail -----
function block_email(event) { // *** TODO ***
    data = {"email": event.currentTarget.email, "date": "?current date?"};
    API.api_request("blocked/", API_METHOD_POST, JSON.stringify(data));
    location.reload();
}