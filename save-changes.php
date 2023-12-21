<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

include 'config.php';

// Check if the user is logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // Assuming the users' details are stored in the 'users' table
    $username = $_SESSION["username"];
    $getUserIDQuery = "SELECT id FROM users WHERE username = ?";
    $stmtGetUserID = $con->prepare($getUserIDQuery);
    $stmtGetUserID->bind_param("s", $username);
    $stmtGetUserID->execute();
    $stmtGetUserID->bind_result($user_id);

    // Fetch user_id for the current user
    if ($stmtGetUserID->fetch()) {
        $stmtGetUserID->close(); // Close the statement before preparing a new one

        // Assuming the user details are stored in the 'user_details' table
        $phone_number = $_POST['phoneNumber'];
        $address = $_POST['address'];
        $province = $_POST['province']; // Add this line for the province

        // Handle file upload
        if (!empty($_FILES['profilePicture']) && isset($_FILES['profilePicture']['name'])) {
            $targetDirectory = "images/";
            $profile_picture = $_FILES['profilePicture']['name'];
            $targetFile = $targetDirectory . basename($profile_picture);
            move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $targetFile);
        } else {
            // If no new image is uploaded, keep the existing image
            $profile_picture = $_POST['existingProfilePicture'];
        }

        // Check if there is existing data for the user_id in user_details
        $checkExistingDataQuery = "SELECT id FROM user_details WHERE user_id = ?";
        $stmtCheckExistingData = $con->prepare($checkExistingDataQuery);
        $stmtCheckExistingData->bind_param("i", $user_id);
        $stmtCheckExistingData->execute();
        $stmtCheckExistingData->store_result();

        if ($stmtCheckExistingData->num_rows > 0) {
            echo '<script>';
            echo 'alert("Changes will be made.");';

            // Delete existing data
            $deleteExistingDataQuery = "DELETE FROM user_details WHERE user_id = ?";
            $stmtDeleteExistingData = $con->prepare($deleteExistingDataQuery);
            $stmtDeleteExistingData->bind_param("i", $user_id);
            $stmtDeleteExistingData->execute();
            $stmtDeleteExistingData->close();

            // Insert or update user details with province
            $saveChangesQuery = "INSERT INTO user_details (user_id, username, phone_number, profile_picture, address, province)
                                VALUES (?, ?, ?, ?, ?, ?)
                                ON DUPLICATE KEY UPDATE phone_number = VALUES(phone_number),
                                                        profile_picture = VALUES(profile_picture),
                                                        address = VALUES(address),
                                                        province = VALUES(province)";

            $stmtSaveChanges = $con->prepare($saveChangesQuery);
            $stmtSaveChanges->bind_param("isssss", $user_id, $username, $phone_number, $profile_picture, $address, $province);
            $stmtSaveChanges->execute();

            echo 'alert("Changes saved successfully!");';
            echo 'window.location.href = "manage-profile.php";';
            echo '</script>';
        } else {
            // No existing data, insert or update user details with province
            $saveChangesQuery = "INSERT INTO user_details (user_id, username, phone_number, profile_picture, address, province)
                                VALUES (?, ?, ?, ?, ?, ?)
                                ON DUPLICATE KEY UPDATE phone_number = VALUES(phone_number),
                                                        profile_picture = VALUES(profile_picture),
                                                        address = VALUES(address),
                                                        province = VALUES(province)";

            $stmtSaveChanges = $con->prepare($saveChangesQuery);
            $stmtSaveChanges->bind_param("isssss", $user_id, $username, $phone_number, $profile_picture, $address, $province);
            $stmtSaveChanges->execute();

            echo '<script>';
            echo 'alert("Changes saved successfully!");';
            echo 'window.location.href = "manage-profile.php";';
            echo '</script>';
        }

        $stmtCheckExistingData->close();
    } else {
        echo "User not found.";
    }
} else {
    echo "User not logged in.";
}
