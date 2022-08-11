document.addEventListener("DOMContentLoaded", function (event) {
    $('#multiple-select-select').mobiscroll().select({
        inputElement: document.getElementById('multiple-select-input'),
        selectMultiple: true
    });
});