const location_options = {
    maximumAge: 0,
    timeout: 2000,
    enableHighAccuracy: true
};

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
const distance_texts = document.querySelectorAll("p.distance-label");
const distance_selector = document.querySelector("select#radius-choice");
const postcode_entry = document.querySelector("input#postcode-entry");
const my_location_button = document.querySelector("img#my-location-button");
const search_button = document.querySelector("div#search-bar svg");
const expertise_suggestions = document.querySelectorAll("div#expertise-search-wrapper li");
const all_checkboxes = document.querySelectorAll("aside#filters input.custom-check")

// Collapse/expand filters
filter_titles.forEach((title) => title.addEventListener("click", (event) => {
    const current_title = event.target;
    const current_list = current_title.nextElementSibling;
    
    current_title.classList.toggle("collapsed");
    current_list.classList.toggle("collapsed");
}));

// Show/hide student interaction filter
student_interaction_input.addEventListener("click", () => {
    student_interaction_section.classList.toggle("shown");
});

// Check/uncheck checkboxes when the text labels associated with them are clicked
checkbox_labels.forEach((label) => label.addEventListener("click", (event) => {
    const current_label = event.target;
    const current_checkbox = document.querySelector("input.custom-check#" + current_label.id);

    current_checkbox.checked = !current_checkbox.checked;
    current_checkbox.dispatchEvent(new Event("click"));
}));

// Disable/enable distance inputs on toggle switch
distance_toggle.addEventListener("click", () => {
    if(distance_toggle.checked) {
        distance_texts.forEach((text) => {
            text.classList.remove("disabled");
        });
        my_location_button.classList.remove("disabled");
        distance_selector.disabled = false;
        postcode_entry.disabled = false;
    } else {
        distance_texts.forEach((text) => {
            text.classList.add("disabled");
        });
        my_location_button.classList.add("disabled");
        distance_selector.disabled = true;
        postcode_entry.disabled = true;
        }
});

// Fill postcode entry with geolocation data
my_location_button.addEventListener("click", () => {
    if(my_location_button.classList.contains("disabled")) return;

    if(!"geolocation" in navigator) {
        alert("Location not available");
        return;
    }

    navigator.geolocation.getCurrentPosition((position) => {
        const coords = position.coords;
        fetch("https://api.postcodes.io/postcodes", {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            method: "POST",
            body: JSON.stringify({"geolocations": [{
                "longitude": coords.longitude,
                "latitude": coords.latitude,
                "radius": 500,
                "limit": 1
            }]})
        })
        .then(response => {
            return response.json();
        })
        .then(json => {
            if(json["status"] != 200) return;

            const postcode = json["result"][0]["result"][0]["postcode"];
            postcode_entry.value = postcode;
        })
    });
});

// Change search parameters with current filters
expertise_input.addEventListener("keyup", (event) => {
    if(event.key === "Enter") handle_filter_change(event);
});
postcode_entry.addEventListener("keyup", (event) => {
    if(event.key === "Enter") handle_filter_change(event);
});
search_button.addEventListener("mousedown", handle_filter_change);
all_checkboxes.forEach((checkboxes) => checkboxes.addEventListener("click", handle_filter_change));
expertise_suggestions.forEach((suggestion) => suggestion.addEventListener("click", 
(event) => {
    console.log("test");
    expertise_input.value = event.target.textContent;
    handle_filter_change(event);
}));

async function handle_filter_change() {
    if(distance_toggle.checked) {
        const valid_postcode = await fetch("https://api.postcodes.io/postcodes/" + postcode_entry.value.replace(/ /g, '') +"/validate")
        .then(response => {return response.json()})
        .then(json => {
            if(json["result"] != true) {
                postcode_entry.setCustomValidity("Not a known postcode");
                postcode_entry.reportValidity();
                return false;
            } else {
                return true;
            }
        });
        if(!valid_postcode) return;
    }

    const expertise_query = expertise_input.value;
    let orgs = [], ages = [], interactions = [], student_interactions = [];

    org_checks.forEach(checkbox => {
        if(checkbox.checked) {
            orgs.push(checkbox.value);
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

    if(distance_toggle.checked) {
        get_url.searchParams.append("postcode", postcode_entry.value);
        get_url.searchParams.append("range", distance_selector.value);
    }

    location.href = get_url.href;
}

// Add suggestions to expertise search
expertise_input.addEventListener("keyup", add_suggestions);

function add_suggestions() {
    if(expertise_input.value == "") {
        for(let i = 0; i < 3; i++) {
            expertise_suggestions[i].textContent = distinct_expertise[i].toLowerCase();
        }
        return;
    }

    const results = fuzzysort.go(expertise_input.value, distinct_expertise);
    
    for(let i = 0; i < 3; i++) {
        expertise_suggestions[i].textContent = (results.length >= i+1) ? results[i]["target"].toLowerCase() : "";
    }
}

// Validate postcode
postcode_entry.addEventListener("input", debounce( () => {
    fetch("https://api.postcodes.io/postcodes/" + postcode_entry.value.replace(/ /g, '') +"/validate")
    .then(response => {return response.json()})
    .then(json => {
        if(json["result"] == true) {
            postcode_entry.setCustomValidity("");
        } else {
            postcode_entry.setCustomValidity("Not a known postcode");
        }
        postcode_entry.reportValidity();
    });
}, 1000));


add_suggestions();