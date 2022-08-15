const hamburger = document.querySelector(".hamburger");
const navMenu = document.querySelector(".navbar");
const navLink = document.querySelectorAll(".navbar a");

hamburger.addEventListener("click", mobileMenu);
navLink.forEach(n => n.addEventListener("click", closeMenu));

function mobileMenu() {
    hamburger.classList.toggle("active");
    navMenu.classList.toggle("active");
}

function closeMenu() {
    hamburger.classList.remove("active");
    navMenu.classList.remove("active");
}

const homeImage = document.querySelector(".logo");
homeImage.addEventListener("click", toHome);

function toHome() {
    window.location.href = "scahome";
}