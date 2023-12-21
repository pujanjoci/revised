<?php
session_start();

require 'config.php';

$itemId = $_POST['itemId'];
$offerAmount = $_POST['offerAmount'];

$username = $_SESSION['username'];

$itemId = mysqli_real_escape_string($con, $itemId);
$offerAmount = mysqli_real_escape_string($con, $offerAmount);

$userQuery = "SELECT id FROM users WHERE username = '$username'";
$userResult = $con->query($userQuery);

if ($userResult && $userResult->num_rows > 0) {
    $userRow = $userResult->fetch_assoc();
    $userId = $userRow['id'];

    $itemQuery = "SELECT i.item_name, i.starting_price, i.item_image, bh.amount AS highest_bid FROM items i
                  LEFT JOIN bidding_history bh ON i.id = bh.item_id AND bh.user_id = '$userId'
                  WHERE i.id = '$itemId'";
    $itemResult = $con->query($itemQuery);

    if ($itemResult && $itemResult->num_rows > 0) {
        $itemRow = $itemResult->fetch_assoc();
        $itemName = $itemRow['item_name'];
        $startingPrice = $itemRow['starting_price'];
        $itemImage = $itemRow['item_image'];
        $highestBid = $itemRow['highest_bid'];

        if ($offerAmount > $startingPrice) {
            if ($highestBid === null || $offerAmount > $highestBid) {
                $insertQuery = "INSERT INTO bidding_history (item_id, item_name, amount, user_id, image_path) 
                                VALUES ('$itemId', '$itemName', '$offerAmount', '$userId', '$itemImage')";

                if ($con->query($insertQuery) === TRUE) {
                    echo '<script>alert("You have successfully bid for the item."); window.location.href = "product_page.php?item_id=' . $itemId . '";</script>';
                    exit;
                } else {
                    echo '<script>alert("Error: ' . $con->error . '"); window.location.href = "product_page.php?item_id=' . $itemId . '";</script>';
                    exit;
                }
            } else {
                echo '<script>alert("You are the highest bidder for now."); window.location.href = "product_page.php?item_id=' . $itemId . '";</script>';
                exit;
            }
        } else {
            echo '<script>alert("Amount should be higher than the current price."); window.location.href = "product_page.php?item_id=' . $itemId . '";</script>';
            exit;
        }
    } else {
        echo '<script>alert("No item details found."); window.location.href = "product_page.php";</script>';
        exit;
    }
} else {
    echo '<script>alert("User not found."); window.location.href = "product_page.php";</script>';
    exit;
}
