const verify_expert_buttons = document.querySelectorAll("button.verify-expert");
const remove_expert_buttons = document.querySelectorAll("button.remove-expert");
const remove_admin_buttons = document.querySelectorAll("button.remove-admin");
const new_admin_entry = document.querySelector("input#new-admin-entry");
const new_admin_button = document.querySelector("button#new-admin-submit");

verify_expert_buttons.forEach((button) => {
    button.addEventListener("click", (event) => {
        let parent = event.target;
        do {
            parent = parent.parentNode;
        } while(parent.tagName != "TR")
        
        console.log("Verify expert with userid " + parent.id);
       
        // update expert table with user id and verfied=1 
        fetch("/api/expert/"+parent.id, {
            method: "PATCH",
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                "admin_verified": 1
            })
        });
        //location.reload()
    });
});

remove_expert_buttons.forEach((button) => {
    button.addEventListener("click", (event) => {
        let parent = event.target;
        do {
            parent = parent.parentNode;
        } while(parent.tagName != "TR")
        
       console.log("Remove expert with userid " + parent.id);

       // update expert table with user id and verified=0
       fetch("/api/expert/"+parent.id, {
        method: "PATCH",
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            "admin_verified": 0
        })
    });
    //location.reload()
    });
});

remove_admin_buttons.forEach((button) => {
    button.addEventListener("click", (event) => {
        let parent = event.target;
        do {
            parent = parent.parentNode;
        } while(parent.tagName != "TR")
        
       console.log("Remove admin with userid " + parent.id);

       // update user table for user level = expert
       fetch("/api/user/"+parent.id, {
        method: "PATCH",
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            "user_level": "Expert"
        })
    });
    //location.reload()
    });
});


new_admin_entry.addEventListener("keyup", (event) => {if(event.keyCode == 13) add_new_admin();});
new_admin_button.addEventListener("click", add_new_admin);
function add_new_admin() {
    if(!new_admin_entry.checkValidity()) {
        new_admin_entry.setCustomValidity("Invalid email address");
        new_admin_entry.reportValidity();
        return;
    }

    const new_admin_email = new_admin_entry.value;

    console.log("Add an admin with email " + new_admin_email);

    // check for user with email

    // if user present, change user level to admin
}