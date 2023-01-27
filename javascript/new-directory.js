const filter_titles = document.querySelectorAll("h3.filter-item-title");

filter_titles.forEach((title) => title.addEventListener("click", (event) => {
    const current_title = event.target;
    const current_list = current_title.nextElementSibling;
    
    current_title.classList.toggle("collapsed");
    current_list.classList.toggle("collapsed");
}));