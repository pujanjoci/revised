<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['send'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

        $checkUserQuery = "SELECT * FROM users WHERE email = ?";
        $checkUserStmt = $con->prepare($checkUserQuery);
        $checkUserStmt->bind_param("s", $email);
        $checkUserStmt->execute();
        $userResult = $checkUserStmt->get_result();

        if ($userResult->num_rows > 0) {
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
                    $mail->setFrom('noreply@rachitauction.com', 'Rachit Auction');
                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Verification Code';
                    $mail->Body = 'Your verification code is: ' . $verificationCode;
                    $mail->send();

                    header('Location: verifyform.php?email=' . urlencode($email));
                    exit;
                } catch (Exception $e) {
                    echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
                }
            } else {
                echo 'Error inserting verification code into the forgot table';
            }

            $insertStmt->close();
        } else {
            // Email not found, display alert and redirect to change.php
            echo '<script>alert("Email not found."); window.location.href = "change.php";</script>';
            exit;
        }

        $checkUserStmt->close();
    } elseif (isset($_POST['verify'])) {
        // Handle verification form submission if needed
        // You can add the verification logic here
    }
}
