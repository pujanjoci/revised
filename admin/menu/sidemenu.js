$(document).ready(function () {
    $('.sidebar-link').on('click', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        $('#content-container').load(href);
    });
});
