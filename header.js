document.querySelector("#burger").addEventListener("click", show_sidebar);
document.querySelector("#close-nav").addEventListener("click", show_sidebar);

function show_sidebar() {
    const menu = document.querySelector("#menu");
    const cross = document.querySelector("#close-nav");

    if(menu.style.transform == "translateX(-200px)") {
        menu.style.transform = "translateX(0px)";
        cross.style.transform = "translateX(0px)";
    } else {
        menu.style.transform = "translateX(-200px)";
        cross.style.transform = "translateX(-200px)";
    }
}

function show_subnav(event) {
    const element = event.target;

    function handle_close_subnav() {
        const navs = document.querySelectorAll(".subnav");
        for(const nav of navs) {
            close_subnav(nav);
        }
    }

    function open_subnav(nav) {
        document.querySelector(".nav-button#" + nav.id).classList.add("open");
        if(window.matchMedia("(max-width: 1000px)").matches) {
            nav.style.maxHeight = "180px";
        } else {
            nav.style.transform = "translateY(20em)";
        }

        document.querySelector("body").addEventListener("click", handle_close_subnav);
    }

    function close_subnav(nav) {
        document.querySelector(".nav-button#" + nav.id).classList.remove("open"); 
        if(window.matchMedia("(max-width: 1000px)").matches) {
            nav.style.maxHeight = "0px";
        } else {
            nav.style.transform = "translateY(0px)";
        }

        document.querySelector("body").removeEventListener("click", handle_close_subnav);
    }

    const subnav = document.querySelector(".subnav#" + element.id);
    const others = document.querySelectorAll(".subnav:not(#" + element.id + ")");

    for(const other_nav of others) {
        close_subnav(other_nav);
    }

    if(element.classList.contains("open")) {
        close_subnav(subnav);
    } else {
        open_subnav(subnav);
    }
    event.stopPropagation();
}

