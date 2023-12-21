<?php
session_start();

require('../config.php');

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    $sql = "SELECT * FROM staff WHERE username = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $name = $row['name'];
        $username = $row['username'];
        $address = $row['address'];
        $employee_id = $row['employee_id'];
        $image_name = $row['image'];
    } else {
        echo "User not found.";
    }
} else {
    echo "User not logged in.";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="../assets/profile.css">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto&display=swap');

        /* profile.css */
        .profile-container {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background-color: rgba(159, 159, 159, 0.885);
            margin-top: 5%;
            max-width: 50%;
            margin-left: 25%;
            border-radius: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 20px;
        }

        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-details {
            margin-top: 5%;
            font-size: 18px;
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>

<body>
    <div class="profile-container">
        <div class="profile-image">
            <?php
            $image_folder = '../image/';

            $image_path = $image_folder . $image_name;
            if (file_exists($image_path)) {
                echo '<img src="' . $image_path . '" alt="Profile Image">';
            } else {
                echo 'Image not found at ' . $image_path;
            }

            ?>
        </div>
        <div class="profile-details">
            <h2><?php echo $name;
                $currentFile = $_SERVER["PHP_SELF"];
                ?></h2>
            <p>Address: <?php echo $address; ?></p>
            <p>Employee ID: <?php echo $employee_id; ?></p>
        </div>
    </div>
</body>

</html>