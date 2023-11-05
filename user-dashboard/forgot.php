<!DOCTYPE html>
<html>

<head>
    <title>Email Verification and Password Reset</title>
    <link rel="stylesheet" type="text/css" href="../assets/forgot.css">
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <?php
    require 'vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'config.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['send'])) {
            // Process the first form submission
            $email = $_POST['email'];

            $query = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($con, $query);
            $user = mysqli_fetch_assoc($result);

            if (!$user) {
                echo "Email not found.";
            } else {
                // Generate a 6-digit random code
                $verificationCode = mt_rand(100000, 999999);

                $insertQuery = "INSERT INTO forgot (email, code) VALUES ('$email', '$verificationCode')";
                mysqli_query($con, $insertQuery);

                // Send the verification code to the user's email using PHPMailer
                try {
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'rachitauction@gmail.com';
                    $mail->Password = 'yogmyaihjmimbcfb';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
                    $mail->setFrom('noreply@example.com', 'Rachit Auction');
                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Verification Code';
                    $mail->Body = 'Your verification code is: ' . $verificationCode;
                    $mail->send();
                    echo 'Verification code sent successfully.';
                } catch (Exception $e) {
                    echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
                }

                // Show the second form using JavaScript
                echo '<script>document.getElementById("email-form").classList.add("hidden");</script>';
            }
        } elseif (isset($_POST['verify'])) {
            // Process the second form submission
            $enteredCode = $_POST['verification_code'];

            $codeQuery = "SELECT * FROM forgot WHERE code = '$enteredCode'";
            $codeResult = mysqli_query($con, $codeQuery);
            $codeRecord = mysqli_fetch_assoc($codeResult);

            if ($codeRecord) {
                // Redirect to reset.php (you should create this file)
                header('Location: reset.php');
            } else {
                echo "Invalid verification code.";
            }
        }
    }
    ?>

    <!-- First Form (Email Input) -->
    <form method="post" id="email-form">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <input type="submit" name="send" value="Send Verification Code">
    </form>

    <!-- Second Form (Verification Code Input) -->
    <form method="post" class="hidden" id="verification-form">
        <label for="verification_code">Enter Verification Code:</label>
        <input type="text" id="verification_code" name="verification_code" required>
        <input type="submit" name="verify" value="Verify">
    </form>

    <script>
        // JavaScript to toggle between the two forms
        document.getElementById("email-form").addEventListener("submit", function(e) {
            e.preventDefault();
            // Process email form submission here
        });

        document.getElementById("verification-form").addEventListener("submit", function(e) {
            e.preventDefault();
            // Process verification form submission here
        });
    </script>
</body>

</html>