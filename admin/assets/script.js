const toggler = document.querySelector(".btn");
toggler.addEventListener("click", function() {
document.querySelector("#sidebar").classList.toggle("collapsed");
});

$(document).ready(function() {
    $("#dashboard-link").click(function() {
        $(".sidebar-link").removeClass("active");
        $(this).addClass("active");
    });
});