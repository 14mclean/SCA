import API from './API.js';

// ----- HTML ELements -----
const approve_expert_buttons = document.querySelectorAll(".approveButton");
const block_email_buttons = document.querySelectorAll(".blockButton");
const new_admin_button = document.querySelector(".newAdminButton");
const remove_admin_buttons = document.querySelectorAll(".demoteAdminButton");


// ----- Event Listeners -----
new_admin_button.addEventListener("click", admin_form_visibility);
document.querySelector(".popup button:not([type=\"submit\"])").addEventListener("click",admin_form_visibility);


for(const button of approve_expert_buttons) {
    button.addEventListener("click", approve_expert);
}

for(const button of remove_admin_buttons) {
    button.addEventListener("click", remove_admin);
}


// ----- Approve expert -----
function approve_expert(event) {
    let data = {"adminVerified": 1};
    API.api_request("experts/"+event.currentTarget.id, API.API_METHOD_PATCH, JSON.stringify(data));
    location.reload();
}


// ----- Demote Admin -----
function remove_admin(event) {
    let data = {"userLevel": "Teacher"};
    API.api_request("users/"+event.currentTarget.id, API.API_METHOD_PATCH, JSON.stringify(data));
    //location.reload();
}


// ----- Block E-Mail -----
function block_email(event) { // *** TODO ***
    let data = {"email": event.currentTarget.email, "date": "?current date?"};
    //API.api_request("blocked/", API.API_METHOD_POST, JSON.stringify(data));
    //location.reload();
}


// ----- Show/Hide add admin -----
function admin_form_visibility(event) {
    let blurDiv = document.querySelector(".blurCover");

    /*if(blurDiv.style.display != "block") {
        blurDiv.style.display = "block";
    } else {
        blurDiv.style.display = "none";
    }*/
    
    if(blurDiv.style.opacity != 1) {
        blurDiv.style.opacity = 1;
    } else {
        blurDiv.style.opacity = 0;
    }
}