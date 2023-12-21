<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require('../config.php');

if (isset($_SESSION['username'])) {
    $sessionUsername = $_SESSION['username'];

    $sql = "SELECT * FROM staff WHERE username = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 's', $sessionUsername);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $name = $row['name'];
        $username = $row['username'];
        $address = $row['address'];
        $employee_id = $row['employee_id'];
        $email = isset($row['email']) ? $row['email'] : '';
        $title = isset($row['title']) ? $row['title'] : '';
        $image_name = $row['image'];
    } else {
        echo "User not found.";
    }
} else {
    echo "User not logged in.";
    exit();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto&display=swap');

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ccc;
            color: #fff;
        }


        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            color: #555;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            margin-top: 30px;
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 20px;
        }

        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
            border: 2px solid #007bff;
        }

        .profile-info {
            flex: 1;
        }

        .profile-info h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .profile-info h2 {
            margin: 5px 0 0;
            font-size: 18px;
            color: #555;
        }

        .profile-form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .profile-form label {
            font-weight: bold;
            margin-bottom: 2px;
            display: block;
            color: #333;
        }

        .profile-form input[type="text"],
        .profile-form input[type="email"],
        .profile-form input[type="password"],
        .profile-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .profile-form input[type="text"]:focus,
        .profile-form input[type="email"]:focus,
        .profile-form input[type="password"]:focus,
        .profile-form select:focus {
            border-color: #007bff;
        }

        .profile-form button {
            width: 40%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            margin: 0 auto;
            display: block;
        }

        .profile-form button:hover {
            background-color: #0056b3;
        }

        .drop-area {
            width: 100%;
            padding: 20px;
            border: 2px dashed #ccc;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
            cursor: pointer;
            margin-bottom: 20px;
            background-color: #fff;
            transition: background-color 0.3s;
        }

        .drop-area:hover {
            background-color: #f8f9fa;
        }

        .file-input {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="profile-header">
            <img src="<?php echo '../image/' . $image_name; ?>" alt="Profile Image" class="profile-image">
            <div class="profile-info">
                <h1><?php echo $name; ?></h1>
                <h2><?php echo $title; ?></h2>
                <h2><?php echo $email; ?></h2>
                <h2><?php echo $address; ?></h2>
            </div>
        </div>
        <form class="profile-form" action="update_profile.php" method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter username">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter email">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter password">

            <label for="address">Address</label>
            <input type="text" id="address" name="address" placeholder="Enter address">

            <label for="role">Role</label>
            <select id="role" name="role">
                <option value="administrator" selected>Administrator</option>
                <option value="staff">Staff</option>
            </select>

            <label for="image">Profile Image</label>
            <input type="file" id="image" name="image" accept="image/*">

            <button type="submit" id="updateButton">Update Profile</button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.querySelector('.profile-form');
            var updateButton = document.getElementById('updateButton');

            if (form && updateButton) {
                form.addEventListener('submit', function(event) {
                    if (!validateUsername() || !validateEmail() || !validatePassword() || !validateImage()) {
                        // Prevent the form submission if validation fails
                        event.preventDefault();
                    }
                });

                function validateUsername() {
                    var usernameInput = document.getElementById('username');
                    var username = usernameInput.value.trim();
                    var usernameRegex = /^[a-zA-Z0-9_-€]{6,}$/;

                    if (!usernameRegex.test(username)) {
                        alert('Username must be 6 or more letters long and only contain alphabets and symbols such as (-,_,€).');
                        return false;
                    }

                    return true;
                }

                function validateEmail() {
                    var emailInput = document.getElementById('email');
                    var email = emailInput.value.trim();
                    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                    if (!emailRegex.test(email)) {
                        alert('Please enter a valid email address.');
                        return false;
                    }

                    return true;
                }

                function validatePassword() {
                    var passwordInput = document.getElementById('password');
                    var password = passwordInput.value.trim();

                    if (password.length < 8) {
                        alert('Password must be 8 or more characters long.');
                        return false;
                    }

                    return true;
                }

                function validateImage() {
                    var imageInput = document.getElementById('image');
                    var allowedFormats = ['jpg', 'jpeg', 'png']; // Add more formats if needed
                    var fileName = imageInput.value.toLowerCase();
                    var fileFormat = fileName.split('.').pop();

                    if (allowedFormats.indexOf(fileFormat) === -1) {
                        alert('Please select a valid image file (jpg, jpeg, png).');
                        return false;
                    }

                    return true;
                }
            }
        });
    </script>


</body>