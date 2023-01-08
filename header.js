function show_subnav(element) {
    function open_subnav(nav) {
        document.querySelector(".nav-button#" + nav.id).classList.add("open");
        if(window.matchMedia("(max-width: 990px)").matches) {
            nav.style.maxHeight = "180px";
        } else {
            nav.style.transform = "translateY(190px)";
        } 
    }

    function close_subnav(nav) {
        document.querySelector(".nav-button#" + nav.id).classList.remove("open"); 
        if(window.matchMedia("(max-width: 990px)").matches) {
            nav.style.maxHeight = "0px";
        } else {
            nav.style.transform = "translateY(0px)";
        }
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
}

document.querySelector("body").addEventListener("click", () => {
    const subnavs = document.querySelectorAll(".subnav");
    for(const nav of subnavs) {
        document.querySelector(".nav-button#" + nav.id).classList.remove("open"); 
        if(window.matchMedia("(max-width: 990px)").matches) {
            nav.style.maxHeight = "0px";
        } else {
            nav.style.transform = "translateY(0px)";
        }
    }
});
    
document.querySelector("#burger").addEventListener("click", show_sidebar);
document.querySelector("#close-nav").addEventListener("click", show_sidebar);

function show_sidebar() {
    const menu = document.querySelector("#menu");
    const cross = document.querySelector("#close-nav");

    if(menu.style.transform == "translateX(-150px)") {
        menu.style.transform = "translateX(0px)";
        cross.style.transform = "translateX(0px)";
    } else {
        menu.style.transform = "translateX(-150px)";
        cross.style.transform = "translateX(-150px)";
    }
}