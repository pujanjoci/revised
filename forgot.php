<!DOCTYPE html>
<html>

<head>
    <title>Email Verification and Password Reset</title>
    <link rel="stylesheet" type="text/css" href="assets/forgot.css">
    <link rel="shortcut icon" href="assets/rachitlogo.png" type="image/png">
    <style>
        body,
        h1,
        h2,
        p,
        label,
        input {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Helvetica', Arial, sans-serif;
            background-color: #f4f4f4;
        }

        form {
            max-width: 300px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 15%;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        input[type="submit"]:disabled {
            background-color: #ddd;
            cursor: not-allowed;
        }

        .hidden {
            display: none;
        }
    </style>
</head>


<?php
// Display errors for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';

$emailExists = false;
$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['send'])) {
        $email = $_POST['email'];

        // Check if the email exists in the users table
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result === false) {
            // Log the SQL error for debugging
            error_log("SQL Error: " . $conn->error);
            $errorMessage = "An error occurred while checking the email. Please try again later.";
        } elseif ($result->num_rows > 0) {
            // Email exists, continue with the verification process
            // You can add your verification code here
            // ...

            // For now, we'll just set the $emailExists variable to true
            $emailExists = true;
        } else {
            // Email not registered, display an error message
            $errorMessage = "Email not registered. Please enter a registered email.";
        }
    }
}
?>

<?php
// Display the error message if there is one
if (!empty($errorMessage)) {
    echo '<p style="color: red;">' . $errorMessage . '</p>';
}
?>

<form method="post" id="email-form" action="forgotcode.php">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <input type="submit" name="send" value="Send Verification Code" onclick="disableButton(this)" <?php if ($emailExists) echo 'disabled'; ?>>
</form>


<form method="post" class="hidden" id="verification-form">
    <label for="verification_code">Enter Verification Code:</label>
    <input type="text" id="verification_code" name="verification_code" required>
    <input type="submit" name="verify" value="Verify">
</form>

<script>
    function disableButton(button) {
        button.disabled = true;
        // Store the state in local storage
        localStorage.setItem('showEmailForm', 'false');
    }

    document.getElementById("email-form").addEventListener("submit", function(e) {
        e.preventDefault();
        // Store the state in local storage
        localStorage.setItem('showEmailForm', 'false');
    });

    document.getElementById("verification-form").addEventListener("submit", function(e) {
        e.preventDefault();
        // Store the state in local storage
        localStorage.setItem('showEmailForm', 'true');
    });

    // Show the email form by default
    document.getElementById('email-form').classList.remove('hidden');
    document.getElementById('verification-form').classList.add('hidden');

    // Check local storage to determine whether to show the email form
    window.onload = function() {
        var showEmailForm = localStorage.getItem('showEmailForm');
        if (showEmailForm === 'true') {
            document.getElementById('email-form').classList.add('hidden');
            document.getElementById('verification-form').classList.remove('hidden');
        } else {
            document.getElementById('email-form').classList.remove('hidden');
            document.getElementById('verification-form').classList.add('hidden');
        }
    };
</script>
</body>

</html>