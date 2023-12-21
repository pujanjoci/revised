<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="shortcut icon" href="assets/rachitlogo.png" type="image/png">
    <style>
        body {
            background-color: #f2f2f2;
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 90vh;
        }

        .card {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            border-radius: 50px;
            background-color: #333;
            padding: 10px;
            text-align: center;
            /* Center the content horizontally */
        }

        .card-img-top img {
            display: inline-block;
            /* Ensure the image is treated as an inline block */
            vertical-align: middle;
            /* Vertically align the image in the middle */
        }

        .card-body {
            padding: 20px;
        }

        .home-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            cursor: pointer;
        }
    </style>
    <title>Password Change Verification</title>
</head>

<body>
    <a href="index.php" class="home-icon">
        <i class="fas fa-home"></i>
    </a>
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 400px;">
            <a href="index.php" class="d-block mx-auto mt-3" style="max-width: 150px;">
                <img src="assets/logo.png" alt="Logo" class="card-img-top" style="border-radius: 50px; background-color: #333; padding: 10px;">
            </a>
            <div class="card-body">
                <h5 class="card-title text-center">Password Change Verification</h5>
                <?php
                include 'config.php';
                require 'vendor/autoload.php';

                use PHPMailer\PHPMailer\PHPMailer;
                use PHPMailer\PHPMailer\Exception;

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (isset($_POST['checkEmail'])) {
                        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

                        $checkUserQuery = "SELECT * FROM users WHERE email = ?";
                        $checkUserStmt = $con->prepare($checkUserQuery);
                        $checkUserStmt->bind_param("s", $email);
                        $checkUserStmt->execute();
                        $userResult = $checkUserStmt->get_result();

                        if ($userResult->num_rows > 0) {
                            // Email exists in the users table, proceed with the verification code sending logic
                            $verificationCode = mt_rand(100000, 999999);

                            $insertQuery = "INSERT INTO forgot (email, code) VALUES (?, ?)";
                            $insertStmt = $con->prepare($insertQuery);
                            $insertStmt->bind_param("si", $email, $verificationCode);

                            if ($insertStmt->execute()) {
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

                                    header('Location: resetcode.php?email=' . urlencode($email));
                                    exit;
                                } catch (Exception $e) {
                                    echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
                                }
                            } else {
                                echo 'Error inserting verification code into the forgot table';
                            }

                            $insertStmt->close();
                        } else {
                            echo '<script>alert("Email not found."); window.location.href = "change.php";</script>';
                            exit;
                        }

                        $checkUserStmt->close();
                    }
                }
                ?>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" name="checkEmail">Check Email</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function disableButton(button) {
            button.disabled = true;
            setTimeout(function() {
                button.disabled = false;
            }, 10000); // 10 seconds
        }

        document.getElementById("form").addEventListener("submit", function(e) {
            e.preventDefault();
        });
    </script>
</body>

</html>