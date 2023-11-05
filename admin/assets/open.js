$(document).ready(function () {
    function loadProfileContent() {
        $.ajax({
            url: 'profile.php',
            type: 'GET',
            success: function (data) {
                // Load the PHP content into the #profile-content div
                $('#profile-content').html(data);
            },
            error: function () {
                alert('Failed to load profile.php');
            }
        });
    }

    // Load profile.php content by default when index.php is opened
    if (window.location.pathname === '/index.php') {
        loadProfileContent();
    }

    // Handle click event for the "Profile" link
    $('#profile-link').click(function (e) {
        e.preventDefault(); // Prevent the link from navigating
        loadProfileContent(); // Load the PHP content
    });
});
