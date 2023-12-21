<?php
$error_message = isset($_GET['error_message']) ? $_GET['error_message'] : "Page not found.";

if (isset($_GET['registration_error'])) {
    $error_message = "Registration Error: " . $error_message;
} else {
    $error_message = "404 - Page Not Found: " . $error_message;
}
echo '<script>alert("' . htmlspecialchars($error_message) . '");</script>';
