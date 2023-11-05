document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('scroll-to-auctions').addEventListener('click', function (e) {
        e.preventDefault();
        var targetElement = document.querySelector(this.getAttribute('href'));
        var targetOffset = targetElement.offsetTop;
        window.scrollTo({
            top: targetOffset,
            behavior: 'smooth'
        });
    });
});