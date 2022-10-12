import API from './API.js';

// ----- HTML ELements -----
const approve_expert_buttons = document.querySelectorAll(".approveButton");
const block_email_buttons = document.querySelectorAll(".blockButton");
const new_admin_button = document.querySelector(".newAdminButton");
const remove_admin_buttons = document.querySelectorAll(".demoteAdminButton");


// ----- Event Listeners -----
new_admin_button.addEventListener("click", admin_form_visibility);
document.querySelector(".popup button:not([type=\"submit\"])").addEventListener("click",admin_form_visibility);
document.querySelector(".popup form").addEventListener("submit", add_admin);


for(const button of approve_expert_buttons) {
    button.addEventListener("click", approve_expert);
}

for(const button of remove_admin_buttons) {
    button.addEventListener("click", remove_admin);
}

// ----- Approve expert -----
function add_admin(event) {
    event.preventDefault();

    let email = document.querySelector(".popup form input").value;

    fetch("/api/users")
    .then((response) => {
        if(response.ok) {
          return response.json();
        } else {
          throw new Error('Server error ' + response.status);
        }
    })
    .then(json => {
        for(const record of json) {
            if(record["email"] == email) {
                fetch("/api/users/"+record["userID"], {
                    method: 'PATCH',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({"userLevel":"Admin"})
                })
                .then((response) => {
                    if(!response.ok) {
                        throw new Error('Server error ' + response.status);
                    }
                });
            }
        }
    });

    location.reload();
    return false;
}


// ----- Approve expert -----
function approve_expert(event) {
    fetch("/api/experts"+event.currentTarget.id, {
        method: 'PATCH',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({"adminVerified": 1})
    })
    .then((response) => {
        if(!response.ok) {
            throw new Error('Server error ' + response.status);
        }
    });
    
    location.reload();
}


// ----- Demote Admin -----
function remove_admin(event) {
    fetch("/api/users/"+event.currentTarget.id, {
        method: 'PATCH',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({"userLevel":"Teacher"})
    }).then((response) => {
        if(!response.ok) {
            throw new Error('Server error ' + response.status);
        }
    });

    location.reload();
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

    if(blurDiv.style.opacity != 1) {
        blurDiv.style.opacity = 1;
        blurDiv.style.height = "100vh";
    } else {
        blurDiv.style.opacity = 0;
        blurDiv.style.height = 0;
    }
}