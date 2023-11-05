<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $sql = "INSERT INTO messages (name, email, message) VALUES (?, ?, ?)";

    $stmt = $con->prepare($sql);

    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $stmt->close();
        $con->close();

        echo '<script>alert("Message sent successfully!");</script>';

        header('Location: index.php');
        exit;
    } else {
        echo "Error sending message. Please try again later.";
    }

    $stmt->close();
    $con->close();
} else {
    echo "Invalid request.";
}
