const burger = document.querySelector("#burger");
const closeNav = document.querySelector("#close-nav");
const menu = document.querySelector("#menu");
const subnav = document.querySelectorAll(".subnav");
const collapsableNavButtons = document.querySelectorAll(".nav-button.collapsable");
const aboutButton = document.querySelector(".nav-button#about");
const body = document.querySelector("body");
const loginButton = document.querySelector(".nav-button#login");

if(loginButton) {
    loginButton.addEventListener("click", () => {
        location.href = "login.html";
    })
}

aboutButton.addEventListener("click", () => {
    location.href = "about.php";
});

function close_all_subnavs() {
    const navs = document.querySelectorAll(".subnav");

    for(const nav of navs) {
        nav.classList.remove("open");
    }
}

collapsableNavButtons.forEach(button => {
    button.addEventListener("click", (event) => {
        

        const element = event.target;
        const subnav = document.querySelector(".subnav#" + element.id);
        const others = document.querySelectorAll(".subnav:not(#" + element.id + ")");

        for(const other_nav of others) {
            other_nav.classList.remove("open");
        }

        subnav.classList.toggle("open");

        if(subnav.classList.contains("open")) {
            body.addEventListener("click", close_all_subnavs);
        } else {
            body.removeEventListener("click", close_all_subnavs);
        }

        event.stopPropagation();
    })
});

[burger, closeNav].forEach(el => { el.addEventListener("click", toggle_sidebar); });

function toggle_sidebar(event) {
    menu.classList.toggle("open-sidebar");
    closeNav.classList.toggle("open-sidebar");

    if(menu.classList.contains("open-sidebar")) {
        body.addEventListener("click", toggle_sidebar);
    } else {
        body.removeEventListener("click", toggle_sidebar);
        close_all_subnavs()
    }
    event.stopPropagation();
}

