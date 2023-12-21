<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require('../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if required fields are empty
    $requiredFields = ['username', 'email', 'password', 'address', 'title'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            header("Location: index.php?error=Please fill the entire form to change user details.");
            exit();
        }
    }

    // Validate and sanitize input data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $address = trim($_POST['address']);
    $title = $_POST['title'];

    // Validate username and check for uniqueness
    $usernameCheckQuery = "SELECT COUNT(*) as count FROM staff WHERE username = ?";
    $stmt = mysqli_prepare($con, $usernameCheckQuery);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row['count'] > 0 && $username !== $_SESSION['username']) {
        // Username already exists for another user, handle accordingly (e.g., redirect with an error message)
        header("Location: index.php?error=Username already in use. Please choose another.");
        exit();
    }

    // Validate email and check for uniqueness
    $emailCheckQuery = "SELECT COUNT(*) as count FROM staff WHERE email = ?";
    $stmt = mysqli_prepare($con, $emailCheckQuery);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row['count'] > 0) {
        // Email already exists, handle accordingly (e.g., redirect with an error message)
        header("Location: index.php?error=Email already in use. Please choose another.");
        exit();
    }

    // Delete previous data for the user
    $deleteQuery = "DELETE FROM staff WHERE username = ?";
    $stmt = mysqli_prepare($con, $deleteQuery);
    mysqli_stmt_bind_param($stmt, 's', $_SESSION['username']);
    mysqli_stmt_execute($stmt);

    // Insert new data into the staff table
    $insertQuery = "INSERT INTO staff (username, email, password, address, title) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $insertQuery);
    mysqli_stmt_bind_param($stmt, 'sssss', $username, $email, $password, $address, $title);

    if (mysqli_stmt_execute($stmt)) {
        // Profile updated successfully, redirect with success message
        header("Location: index.php?success=Profile updated successfully.");
        exit();
    } else {
        // Error updating profile, redirect with error message
        header("Location: index.php?error=Error updating profile. Please try again.");
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    // Invalid request, redirect with error message
    header("Location: index.php?error=Invalid request.");
    exit();
}
