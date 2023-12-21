<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["item_id"])) {
    $item_id = $_POST["item_id"];
    session_start();
    $user_id = $_SESSION["id"];

    $removeQuery = "DELETE FROM bidding_history WHERE item_id = ? AND user_id = ?";
    $stmtRemove = $con->prepare($removeQuery);

    if ($stmtRemove) {
        $stmtRemove->bind_param("ii", $item_id, $user_id);
        $stmtRemove->execute();
        $stmtRemove->close();
    }

    $con->close();

    header("Location: profile.php");
    exit();
}
