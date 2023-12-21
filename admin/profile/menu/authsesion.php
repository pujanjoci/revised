<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    include '../config.php';

    $staff_id = $_SESSION['id'];
    $username = $_SESSION['username'];

    $stmt = $con->prepare("SELECT id FROM staff WHERE id=? AND username=?");
    $stmt->bind_param("ss", $staff_id, $username);

    if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Combination of staff ID and username exists in the staff table
            $_SESSION['authenticated'] = true;
        } else {
            // Combination does not exist, invalidate the session
            session_destroy();
            header('Location: ../login.php');
            exit();
        }
    } else {
        // Database query error, invalidate the session
        session_destroy();
        header('Location: ../login.php');
        exit();
    }

    $stmt->close();
    $con->close();
} else {
    session_destroy();
    header('Location: ../login.php');
    exit();
}

if (isset($_SESSION['expiration_time']) && time() > $_SESSION['expiration_time']) {
    // Session has expired
    session_destroy();
    header('Location: ../login.php');
    exit();
}
