<?php
include 'config.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_var($_POST['username']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = md5($_POST['password']);

    $checkUserQuery = "SELECT username, email FROM users WHERE username = ? OR email = ?";
    $checkUserStmt = $con->prepare($checkUserQuery);
    $checkUserStmt->bind_param("ss", $username, $email);
    $checkUserStmt->execute();
    $checkUserStmt->store_result();

    if ($checkUserStmt->num_rows > 0) {
        header('Location: register.php?error=useremailerror');
        exit;
    }

    $checkEmailQuery = "SELECT email FROM registration WHERE email = ?";
    $checkEmailStmt = $con->prepare($checkEmailQuery);
    $checkEmailStmt->bind_param("s", $email);
    $checkEmailStmt->execute();
    $checkEmailStmt->store_result();

    if (
        $checkEmailStmt->num_rows > 0
    ) {
        header('Location: register.php?error=registrationerror');
        exit;
    }


    $verificationCode = mt_rand(100000, 999999);
    $currentDateTime = date('Y-m-d H:i:s');

    $insertRegistrationQuery = "INSERT INTO registration (username, password, email) VALUES (?, ?, ?)";
    $insertRegistrationStmt = $con->prepare($insertRegistrationQuery);
    $insertRegistrationStmt->bind_param("sss", $username, $password, $email);

    if ($insertRegistrationStmt->execute()) {
        $insertVerifyQuery = "INSERT INTO verify (email, verification_code, created_at) VALUES (?, ?, ?)";
        $insertVerifyStmt = $con->prepare($insertVerifyQuery);
        $insertVerifyStmt->bind_param("sis", $email, $verificationCode, $currentDateTime);

        if ($insertVerifyStmt->execute()) {
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'rachitauction@gmail.com';
                $mail->Password = 'yogmyaihjmimbcfb';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom('rachitauction@gmail.com', 'Rachit Auction');
                $mail->addAddress($email);
                $mail->Subject = 'Verification Code';
                $mail->Body = "Your verification code is: $verificationCode";

                if ($mail->send()) {
                    header('Location: verifyform.php?email=' . urlencode($email));
                    exit;
                } else {
                    echo 'Error sending email: ' . $mail->ErrorInfo;
                }
            } catch (Exception $e) {
                echo 'Error creating PHPMailer instance: ' . $e->getMessage();
            }
        } else {
            echo 'Error inserting verification code into the verify table';
        }
    } else {
        echo 'Error inserting registration data into the registration table';
    }

    $insertRegistrationStmt->close();
    $insertVerifyStmt->close();
    $checkUserStmt->close();
}
