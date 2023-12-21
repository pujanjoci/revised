<?php
session_start();
include 'config.php';

$username = "";
$headerText = "";
$logoutButton = "";
$biddingHistory = [];

// Check if the user is logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $username = $_SESSION["username"];

    // Retrieve user ID
    $userQuery = "SELECT id FROM users WHERE username = ?";
    $stmtUser = $con->prepare($userQuery);
    $stmtUser->bind_param("s", $username);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();

    if ($resultUser->num_rows > 0) {
        $rowUser = $resultUser->fetch_assoc();
        $sessionUserId = $rowUser["id"];

        // Retrieve bidding history for the current user
        $biddingHistoryQuery = "
            SELECT bh.item_id, items.item_name, MAX(bh.amount) AS max_amount, bh.image_path
            FROM bidding_history bh
            JOIN items ON bh.item_id = items.id
            WHERE bh.user_id = ?
            GROUP BY bh.item_id
        ";

        $stmtBiddingHistory = $con->prepare($biddingHistoryQuery);
        $stmtBiddingHistory->bind_param("i", $sessionUserId);
        $stmtBiddingHistory->execute();
        $resultBiddingHistory = $stmtBiddingHistory->get_result();
    }
} else {
    // Redirect to index.php if the user is not logged in
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-...your-integrity-code-here..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico&display=swap">
    <link rel="stylesheet" href="assets/header.css">
    <link rel="shortcut icon" href="assets/rachitlogo.png" type="image/png">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #08080868;
            color: #fff;
            padding: 5px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        #user-info a {
            color: #777;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            padding: 5px 10px;
            transition: background-color 0.3s;
        }

        #user-info a:hover {
            background-color: #ddd;
            border-radius: 20px;
        }

        .container {
            max-width: 80%;
            margin: 20px auto;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            border: 2px solid #ddd;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #bid-history {
            font-size: 24px;
            font-weight: bold;
            margin-top: 0;
            padding-bottom: 10px;
        }

        #manage-profile {
            display: flex;
            align-items: center;
        }

        #manage-profile-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            margin-left: 10px;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.3s;
        }

        #manage-profile-button:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        #bidding-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            border-top: 2px solid #ddd;
        }

        #bidding-table th,
        #bidding-table td {
            border: none;
            padding: 10px;
            text-align: center;
        }

        #bidding-table img {
            width: 50%;
            height: 50%;
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        #bidding-table thead {
            border-bottom: 2px solid #ddd;
        }

        #bidding-table tbody {
            border-top: 2px solid #ddd;
        }

        #search-bar {
            width: 100%;
            margin-top: 20px;
            padding: 10px;
            border-top: 2px solid #ddd;
            position: relative;
            display: flex;
        }

        #search-input {
            width: 20%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        #search-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 5px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        #search-button:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <header>
        <div id="logo">
            <a href="index.php">
                <img src="assets/logo.png" alt="Your Logo">
            </a>
        </div>

        <?php
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            echo '<div id="user-info-and-logout">';
            echo '<div id="user-info" style="font-family: \'Pacifico\', cursive;">';
            echo '<a href="profile.php">' . $_SESSION["username"] . '</a>';
            echo '</div>';
            echo '<div id="logout-button">';
            echo '<a href="logout.php"><i class="fas fa-sign-out-alt"></i></a>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div id="login-register">';
            echo '<a href="login.html"><button id="login-button">Login</button></a>';
            echo '</div>';
        }
        ?>
    </header>

    <div class="container">
        <div id="bid-history">Bid History</div>
        <div id="manage-profile">
            <a href="manage-profile.php">
                <button id="manage-profile-button"><i class="fas fa-cog"></i> Manage Profile</button>
            </a>
        </div>

        <?php
        // Display bidding history if available
        echo '<table id="bidding-table">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Amount</th>
                <th>Image</th>
                <th></th>
                <th>Action</th>
                <th> </th>
            </tr>
        </thead>
        <tbody>';

        // Display bidding history if available
        if (isset($resultBiddingHistory) && $resultBiddingHistory->num_rows > 0) {
            $maxAmounts = [];

            while ($bidHistory = $resultBiddingHistory->fetch_assoc()) {
                $itemId = $bidHistory['item_id'];

                // If the item ID is not already in $maxAmounts or if the current amount is greater
                if (!isset($maxAmounts[$itemId]) || $bidHistory['max_amount'] > $maxAmounts[$itemId]['max_amount']) {
                    $maxAmounts[$itemId] = $bidHistory;
                }
            }

            foreach ($maxAmounts as $bidHistory) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($bidHistory['item_name'] ?? '') . '</td>';
                echo '<td>' . htmlspecialchars($bidHistory['max_amount']) . ' NRP</td>';
                $imagePath = htmlspecialchars($bidHistory['image_path'] ?? '');
                echo '<td><img src="images/' . $imagePath . '" alt="Item Image"></td>';
                echo '<td>';
                echo '<form action="remove_item.php" method="post">';
                echo '<input type="hidden" name="item_id" value="' . htmlspecialchars($bidHistory['item_id']) . '">';
                echo '<button type="submit" class="remove-button">Remove</button>';
                echo '</form>';
                echo '</td>';
                echo '<td>';
                echo '<form action="payment_process.php" method="post">';
                echo '<input type="hidden" name="item_id" value="' . htmlspecialchars($bidHistory['item_id']) . '">';
                echo '<button type="submit" class="pay-button">Pay</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            // Display a message if no bidding history is found
            echo '<tr><td colspan="6" style="text-align: center; font-size: 18px;"></br>There is no items </br></br>You should start bidding.</td></tr>';
        }


        echo '</tbody></table>';
        ?>


        <div id="search-bar">
            <input type="text" id="search-input" placeholder="Search...">
            <button id="search-button">
                <i id="search-icon" class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var removeButtons = document.querySelectorAll('.remove-button');
            removeButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var itemId = this.getAttribute('data-id');
                    if (confirm('Are you sure you want to remove this item?')) {
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'remove_item.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                var row = button.closest('tr');
                                row.parentNode.removeChild(row);
                            } else {
                                console.error(xhr.statusText);
                            }
                        };
                        xhr.onerror = function() {
                            console.error('Network error');
                        };
                        xhr.send('id=' + encodeURIComponent(itemId));
                    }
                });
            });
        });
    </script>
</body>

</html>