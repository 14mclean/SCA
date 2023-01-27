const filter_titles = document.querySelectorAll("h3.filter-item-title");
const student_interaction_input = document.querySelector("input.custom-check#interactions-student");
const student_interaction_section = document.querySelector("section.filter-item#student-interactions");
const checkbox_labels = document.querySelectorAll("label.filter-label");
const expertise_input = document.querySelector("div#search-bar input");
const org_checks = document.querySelectorAll("section.filter-item#organisations input");
const age_checks = document.querySelectorAll("section.filter-item#ages input");
const interaction_checks = document.querySelectorAll("section.filter-item#interactions input");
const student_interaction_checks = document.querySelectorAll("section.filter-item#student-interactions input");
const distance_toggle = document.querySelector("input.toggle");

filter_titles.forEach((title) => title.addEventListener("click", (event) => {
    const current_title = event.target;
    const current_list = current_title.nextElementSibling;
    
    current_title.classList.toggle("collapsed");
    current_list.classList.toggle("collapsed");
}));

student_interaction_input.addEventListener("click", () => {
    student_interaction_section.classList.toggle("shown");
});

checkbox_labels.forEach((label) => label.addEventListener("click", (event) => {
    const current_label = event.target;
    const current_checkbox = document.querySelector("input.custom-check#" + current_label.id);

    current_checkbox.checked = !current_checkbox.checked;
    current_checkbox.dispatchEvent(new Event("click"));
}));

distance_toggle.addEventListener("click", () => {
    if(!"geolocation" in navigator) {
        alert("No geolocation available!");
        distance_toggle.checked = false;
        // disable all
    }
    
    navigator.permissions.query({name:'geolocation'}).then(function(result) {
        if (result.state == 'granted') {
            console.log("granted");
        } else if (result.state == 'prompt') {
            console.log("prompted");
        } else if (result.state == 'denied') {
            console.log("denied");
        }
      });

    // toggle geolocation permission
    // enable/disable other inputs
});


function handle_filter_change() {
    const expertise_query = expertise_input.value;
    let orgs = [], ages = [], interactions = [], student_interactions = [];

    org_checks.forEach(checkbox => {
        if(checkbox.checked) {
            orgs.push(checkbox.nextElementSibling.textContent);
        }
    });

    age_checks.forEach(checkbox => {
        if(checkbox.checked) {
            ages.push(checkbox.id);
        }
    });

    interaction_checks.forEach(checkbox => {
        if(checkbox.checked) {
            interactions.push(checkbox.id);
        }
    });

    if(interactions.includes("interactions-student")) {
        student_interaction_checks.forEach(checkbox => {
            if(checkbox.checked) {
                student_interactions.push(checkbox.id);
            }
        })
    }

    // distance stoof

    function format_filters(filters) {
        let url_appendage = "";
        for (const value of filters) {
            url_appendage += value + "|";
        }
        return url_appendage.slice(0, -1);
    }

    let get_url = new URL("https://www.schoolcitizenassemblies.org/directory.php");

    if(expertise_query != "") {
        get_url.searchParams.append("expertise", expertise_query);
    }

    if(ages.length > 0) {
        get_url.searchParams.append("age", format_filters(ages));
    }

    if(orgs.length > 0) {
        get_url.searchParams.append("organisation", format_filters(orgs));
    }

    if(interactions.length > 0) {
        get_url.searchParams.append("interaction", format_filters(interactions));
    }

    if(student_interactions.length > 0) {
        get_url.searchParams.append("student_interaction", format_filters(student_interactions));
    }

    // add distance

    // 
}