<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'config.php';

    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $hashedPassword = md5($password);

    $sql = "SELECT id FROM users WHERE username=? AND password=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        $stmt->bind_result($user_id);

        if ($stmt->fetch()) {
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
            $_SESSION["id"] = $user_id;

            $stmt->close();

            header("Location: index.php");
            exit();
        } else {
            $error = "Username or password is incorrect";
            echo '<script>alert("' . $error . '"); window.location.href = "login.html";</script>';
            exit();
        }
    } else {
        $error = "Database query error";
        error_log($error);
        echo '<script>alert("' . $error . '"); window.location.href = "login.html";</script>';
        exit();
    }
} else {
    $error = "Invalid request";
    error_log($error);
    echo '<script>alert("' . $error . '"); window.location.href = "login.html";</script>';
    exit();
}
