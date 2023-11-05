<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&family=Playfair+Display:ital@1&display=swap" rel="stylesheet">
    <title>Registration Page</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .container {
            background-color: #ffffff;
            border-radius: 75px;
            padding: 45px;
            box-shadow: 0px 3px 9px rgba(0, 0, 0, 0.522);
            text-align: center;
            border: 2px solid #3e54ff4f;
        }

        .heading {
            font-family: 'Oswald', sans-serif;
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-family: 'Times New Roman', Times, serif;
            font-size: medium;
            text-align: left;
            margin-bottom: 7px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            border: 1px solid #98979795;
            border-radius: 10px;
        }

        button {
            background-color: #007bffce;
            color: #ffffff;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 15px;
            margin-top: 10px;
        }

        button:hover {
            background-color: #374f679c;
        }

        button:active {
            background-color: #2e447e8c;
            animation: shakeAndShrink 0.5s ease-in-out;
        }

        @keyframes shakeAndShrink {

            0%,
            100% {
                transform: scale(1);
            }

            25% {
                transform: scale(0.85) translateX(-5px);
            }

            50% {
                transform: scale(1.05) translateY(-5px);
            }

            75% {
                transform: scale(0.95) translateX(1px);
            }
        }


        .forgot {
            text-decoration: none;
            color: #000;
            font-size: 16px;
            font-family: 'Times New Roman', Times, serif;
            margin-top: 20px;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .password-wrapper {
            position: relative;
        }

        input[type="password"] {
            width: calc(100% - 10%);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 7px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
        }


        #fa-eye {
            position: absolute;
            top: 55%;
            left: 88%;
            right: 1px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #999;
        }

        .home-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <a href="dashboard.php" class="home-icon">
        <i class="fas fa-home"></i>
    </a>

    <div class="container">
        <div class="heading">Registration Form</div>
        <form method="post" action="registration.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" pattern="^\S+$" title="No spaces allowed" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" minlength="6" required>
                    <i class="fa fa-eye toggle-password" id="fa-eye" onclick="togglePasswordVisibility()"></i>
                </div>
            </div>
            <button type="submit">Register</button>
        </form>
        <div class="forgot">
            <a href="login.html">Already have an account?</a>
        </div>
    </div>
    <?php
    if (isset($_GET["error"])) {
        include("error.php");
    }
    ?>

    <script>
        if (window.location.search.includes('error=registrationerror')) {
            var newUrl = window.location.href.replace('?error=registrationerror', '');
            window.history.replaceState({}, document.title, newUrl);
        }
        if (window.location.search.includes('error=useremailerror')) {
            var newUrl = window.location.href.replace('?error=useremailerror', '');
            window.history.replaceState({}, document.title, newUrl);
        }


        function togglePasswordVisibility() {
            var passwordField = document.getElementById("password");
            var toggleIcon = document.querySelector(".toggle-password");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            }
        }

        var passwordField = document.getElementById("password");
        var toggleIcon = document.querySelector(".toggle-password");

        passwordField.type = "password";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");

        window.onload = function() {
            var existingErrorMessage = document.querySelector(".message");
            if (existingErrorMessage) {
                existingErrorMessage.remove();
            }
        }

        var urlParams = new URLSearchParams(window.location.search);
        var isRedirectedFromRegister = urlParams.get("redirected") === "true";

        if (isRedirectedFromRegister) {
            alert("Username or Email already exists");
        }
    </script>

</body>

</html>