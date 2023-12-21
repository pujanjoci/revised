<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Change</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="shortcut icon" href="assets/rachitlogo.png" type="image/png">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        label {
            display: block;
            margin: 20px 0 8px;
            color: #555;
        }

        input {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            display: inline-block;
        }

        .password-toggle {
            position: relative;
            cursor: pointer;
            display: inline-block;
        }

        .password-toggle i {
            position: absolute;
            top: 35%;
            right: 8%;
            transform: translateY(-50%);
            color: #777;
            cursor: pointer;
        }

        input[type="password"]+.password-toggle i.fa-eye-slash {
            display: none;
        }

        input[type="password"].show-password+.password-toggle i.fa-eye {
            display: none;
        }

        input[type="password"].show-password+.password-toggle i.fa-eye-slash {
            display: inline-block;
        }

        input[type="password"]+.password-toggle i.fa-eye {
            display: inline-block;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
            border: none;
            padding: 12px;
            border-radius: 4px;
            font-size: 16px;
            width: 50%;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Password Change Form</h2>
        <?php
        // Check if verification code is present in the URL
        if (!isset($_GET['verification']) || $_GET['verification'] !== 'changepassword') {
            header("Location: index.php");
            exit();
        }

        include 'config.php';

        // Function to securely hash passwords using MD5
        function hashPassword($password)
        {
            return md5($password);
        }

        // Function to check if the new password is not the same as the old password
        function isNewPasswordDifferentFromOld($newPassword, $oldPassword)
        {
            return hashPassword($newPassword) !== $oldPassword;
        }

        // Function to check if the new password is the same as the old password
        function isNewPasswordSameAsOld($newPassword, $oldPassword)
        {
            return hashPassword($newPassword) === $oldPassword;
        }

        // Get user email from the URL
        $email = $_GET['email'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];

            // Retrieve MD5-encrypted old password from 'users' table
            $sql = "SELECT password FROM users WHERE email = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($oldPassword);
            $stmt->fetch();
            $stmt->close();

            // Check if the new password is not the same as the old password
            if (isNewPasswordDifferentFromOld($newPassword, $oldPassword)) {
                // Check if the new password and confirm password match
                if ($newPassword === $confirmPassword) {
                    // Update the user's password in the 'users' table
                    $hashedPassword = hashPassword($newPassword);
                    $updateSql = "UPDATE users SET password = ? WHERE email = ?";
                    $updateStmt = $con->prepare($updateSql);
                    $updateStmt->bind_param("ss", $hashedPassword, $email);
                    $updateStmt->execute();
                    $updateStmt->close();

                    // Password successfully changed, redirect to login.html
                    header("Location: login.html");
                    exit();
                } else {
                    echo '<script>alert("Passwords don\'t match.");</script>';
                }
            } elseif (isNewPasswordSameAsOld($newPassword, $oldPassword)) {
                echo '<script>alert("Password can\'t be the same as the old password.");</script>';
            } else {
                echo '<script>alert("An unexpected error occurred.");</script>';
            }
        }
        ?>
        <form method="post">
            <label for="newPassword">New Password:</label>
            <div class="password-toggle">
                <input type="password" name="newPassword" id="newPassword" required>
                <i class="fas fa-eye" onclick="togglePassword('newPassword')"></i>
                <i class="fas fa-eye-slash" onclick="togglePassword('newPassword')"></i>
            </div>

            <label for="confirmPassword">Confirm Password:</label>
            <div class="password-toggle">
                <input type="password" name="confirmPassword" id="confirmPassword" required>
                <i class="fas fa-eye" onclick="togglePassword('confirmPassword')"></i>
                <i class="fas fa-eye-slash" onclick="togglePassword('confirmPassword')"></i>
            </div>

            <input type="submit" value="Change Password">
        </form>

        <script>
            function togglePassword(inputId) {
                const input = document.getElementById(inputId);
                input.type = input.type === "password" ? "text" : "password";
                input.classList.toggle("show-password");
            }
        </script>
    </div>
</body>

</html>