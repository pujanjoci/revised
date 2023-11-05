<?php
session_start();

// Check if the session variable 'user_id' is set
if (isset($_SESSION['user_id'])) {
    // Check if the session expiration time has passed
    if (isset($_SESSION['expiration_time']) && time() > $_SESSION['expiration_time']) {
        // Session has expired
        echo 'Session expired';
        // You may also want to unset or destroy the session here
        // unset($_SESSION['user_id']);
        // session_destroy();
    } else {
        // Session is still valid
        echo 'Session is active';
    }
} else {
    // User is not logged in
    echo 'User is not logged in';
}
