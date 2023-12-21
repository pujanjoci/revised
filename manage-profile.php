<?php
session_start();

include 'config.php';

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit;
}

// Initialize variables
$username = "";
$email = "";
$sessionUsername = ""; // Add this line

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $username = $_SESSION["username"];
    $sessionUsername = $username; // Add this line

    // Fetch user_id for the current user
    $userQuery = "SELECT id, email FROM users WHERE username = ?";
    $stmtUser = $con->prepare($userQuery);
    $stmtUser->bind_param("s", $username);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();

    if ($resultUser->num_rows > 0) {
        $rowUser = $resultUser->fetch_assoc();
        $user_id = $rowUser["id"];
        $email = $rowUser["email"];

        $headerText = "Hi, " . $username . " ";
        $logoutButton = '<a href="logout.php" id="logout-button"><span class="logout-icon">&#10148;</span></a>';

        // Fetch user details from the database for the current user
        $userDetailsQuery = "SELECT id, username, email FROM users WHERE id = ?";
        $stmtUserDetails = $con->prepare($userDetailsQuery);
        $stmtUserDetails->bind_param("i", $user_id);
        $stmtUserDetails->execute();
        $resultUserDetails = $stmtUserDetails->get_result();

        if ($resultUserDetails->num_rows > 0) {
            $rowUserDetails = $resultUserDetails->fetch_assoc();
            $user_id = $rowUserDetails["id"];
            $username = $rowUserDetails["username"];
            $email = $rowUserDetails["email"];
        } else {
            echo "User details not found.";
        }

        $stmtUserDetails->close();
    } else {
        echo "User not found.";
    }

    $stmtUser->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-...your-integrity-code-here..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico&display=swap">
    <link rel="shortcut icon" href="assets/rachitlogo.png" type="image/png">
    <link rel="stylesheet" href="assets/header.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #08080868;
            color: #fff;
            padding: 5px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        #user-info a {
            color: #777;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            padding: 5px 10px;
            transition: background-color 0.3s;
        }

        #user-info a:hover {
            background-color: #ddd;
            border-radius: 20px;
        }

        #user-details-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            position: relative;
            border-radius: 15px;
        }

        #user-details {
            width: 40%;
            margin: 50%;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        #user-details h2 {
            color: #333;
            margin-bottom: 15px;
        }

        #user-details p {
            margin-bottom: 10px;
        }

        #update-form {
            width: 30%;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        #update-form label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        #update-form input {
            width: 80%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            text-align: center;
        }

        #update-form input[type="submit"] {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        #update-form input[type="submit"]:hover {
            background-color: #45a049;
        }

        .profile-container {
            width: 40%;
            margin-top: 5%;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .profile-picture {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 50%;
        }

        .profile-name {
            margin-top: 20px;
            font-size: 24px;
            color: #333;
        }

        .profile-email,
        .profile-address {
            margin-top: 10px;
            font-size: 16px;
            color: #666;
        }

        .phone-input-container {
            display: flex;
            align-items: center;
        }

        .prefix {
            margin-right: 5px;
            margin-bottom: 6%;
            padding: 8px;
            background-color: #ddd;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
        }

        #phoneNumber {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 0 5px 5px 0;
        }

        #manageItemsButton {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        #manageItemsButton:hover {
            background-color: #45a049;
        }

        #province {
            width: 80%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            margin-bottom: 15px;
        }

        #province option {
            background-color: #fff;
            color: #333;
        }

        #province option:checked {
            background-color: #e0e0e0;
        }

        #address {
            width: 80%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <header>
        <div id="logo">
            <a href="index.php">
                <img src="assets/logo.png" alt="Your Logo">
            </a>
        </div>

        <?php
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            echo '<div id="user-info-and-logout">';
            echo '<div id="user-info" style="font-family: \'Pacifico\', cursive;">';
            echo '<a href="profile.php">' . $_SESSION["username"] . '</a>';
            echo '</div>';
            echo '<div id="logout-button">';
            echo '<a href="logout.php"><i class="fas fa-sign-out-alt"></i></a>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div id="login-register">';
            echo '<a href="login.html"><button id="login-button">Login</button></a>';
            echo '</div>';
        }
        ?>
    </header>

    <div id="user-details-container">
        <div class="profile-container">
            <?php
            // Assuming your tables are named 'users' and 'user_details',
            // and you have columns 'profile_picture' and 'address' in 'user_details' table
            $query = "SELECT ud.profile_picture, ud.address
              FROM users u
              JOIN user_details ud ON u.id = ud.user_id
              WHERE u.username = '$sessionUsername'";

            $result = mysqli_query($con, $query);

            if ($result) {
                $row = mysqli_fetch_assoc($result);

                // Check if 'profile_picture' key exists and is not empty
                if (isset($row['profile_picture']) && !empty($row['profile_picture'])) {
                    $existingProfilePicture = $row['profile_picture'];
                    echo '<img class="profile-picture" src="images/' . $existingProfilePicture . '" alt="Profile Picture">';
                } else {
                    // Display the font-awesome icon when 'profile_picture' is empty or not set
                    echo '<i class="fas fa-user-circle fa-5x" style="color: #333;"></i>';
                }

                // Check if 'address' key exists and is not empty
                if (isset($row['address']) && !empty($row['address'])) {
                    $userAddress = $row['address'];
                    echo '<h1 class="profile-name">' . $username . '</h1>';
                    echo '<p class="profile-address">' . $userAddress . '</p>';
                } else {
                    // Handle the case when 'address' is empty or not set
                    echo '<h1 class="profile-name">' . $username . '</h1>';
                    echo '<p class="profile-address">No address available</p>';
                }
            } else {
                // Handle the query error or no matching user error as needed
                echo 'Error fetching profile information.';
            }
            ?>
        </div>


        <button id="manageItemsButton" onclick="window.location.href='profile.php'">
            <i class="fas fa-cogs"></i> Manage Items
        </button>

        <div id="update-form">
            <form method="post" action="save-changes.php" enctype="multipart/form-data">
                <label for="newUsername">Username:</label>
                <input type="text" id="newUsername" name="newUsername" value="<?php echo $username; ?>" required readonly>

                <label for="phoneNumber">Phone Number:</label>
                <div class="phone-input-container">
                    <span class="prefix">+977</span>
                    <input type="tel" id="phoneNumber" name="phoneNumber" pattern="[0-9]{10}" required>
                </div>

                <label for="profilePicture">Profile Picture (png, jpg, jpeg):</label>
                <input type="file" id="profilePicture" name="profilePicture" accept=".png, .jpg, .jpeg">

                <input type="hidden" name="existingProfilePicture" value="<?php echo $existingProfilePicture; ?>">

                <label for="province">Province:</label>
                <select id="province" name="province" required>
                    <option value="" disabled selected>Select Province</option>
                    <option value="Province 1">Province 1 (Eastern)</option>
                    <option value="Province 2">Province 2 (Madhesh)</option>
                    <option value="Bagmati Province">Bagmati Province</option>
                    <option value="Gandaki Province">Gandaki Province</option>
                    <option value="Lumbini Province">Lumbini Province</option>
                    <option value="Karnali Province">Karnali Province</option>
                    <option value="Sudurpashchim Province">Sudurpashchim Province</option>
                </select>

                <input type="text" id="address" name="address" placeholder="Address" required>


                <input type="submit" class="save" name="saveChanges" value="Save Changes">
            </form>
        </div>
    </div>

</body>

</html>