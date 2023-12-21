<?php
session_start();

require('config.php');

$headerText = "";
$logoutButton = "";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $headerText = "Hi, " . $_SESSION["username"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Product Store</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/header.css">
    <link rel="shortcut icon" href="assets/rachitlogo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-...your-integrity-code-here..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico&display=swap">
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
        }

        main {
            width: 90%;
            margin: 0 auto;
        }

        main {
            padding: 20px;
        }

        .product {
            margin-top: 10%;
            display: flex;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 75%;
            margin: 0 auto;
            align-items: center;
            margin-bottom: 5%;
        }

        .product-photos {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .thumbnail {
            max-width: 100px;
            cursor: pointer;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

        .active-thumbnail {
            border: 2px solid #e44d26;
        }

        .viewer {
            display: flex;
            position: relative;
            z-index: 2;
            width: 500%;
            height: 500%;
            margin: 5%;
        }


        .viewer img {
            max-width: 100%;
            max-height: 100%;
            cursor: pointer;
            margin: auto;
        }

        .product-info {
            margin-left: 20px;
        }

        .make-offer {
            background-color: #e44d26;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
            margin-bottom: 10px;
            width: 100px;
            border-radius: 15px;
            margin-top: 3%;
        }

        .price-input-wrapper {
            display: flex;
            align-items: center;
        }

        .price-input {
            width: 100px;
            padding: 10px;
            box-sizing: border-box;
            margin-right: 8px;
            border-radius: 15px;
        }

        .price-input::placeholder {
            margin-left: 10px;
            color: #999;
        }

        .gallery-heading {
            margin-left: 3%;
            margin-bottom: 3%;
            font-size: 1em;
            color: #333;
        }

        #user-info a {
            color: #333;
            padding: 5px 10px;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
        }

        #user-info a:hover {
            background-color: #ddd;
            border-radius: 20px;
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
            echo '<a href="profile.php">' . $headerText . '</a>';
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

    <main>
        <?php
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            $item_id = $_GET['item_id'];

            $sql = "SELECT * FROM items WHERE id = $item_id";
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $biddingSql = "SELECT MAX(amount) AS max_amount FROM bidding_history WHERE item_id = $item_id";
                $biddingResult = $con->query($biddingSql);
                $biddingRow = $biddingResult->fetch_assoc();

                $currentAmount = ($biddingRow['max_amount'] !== null) ? $biddingRow['max_amount'] : $row['starting_price'];

                echo "<section class='product'>
        <div class='product-photos'>
            <img class='thumbnail active-thumbnail' src='images/{$row['item_image']}' alt='{$row['item_name']}' onclick='openLightbox(\"images/{$row['item_image']}\')'>
        </div>
        <div class='viewer' id='lightbox'>
            <img src='images/{$row['item_image']}' alt='{$row['item_name']}'>
        </div>
        <div class='product-info'>
            <h2>{$row['item_name']}</h2>
            <p>{$currentAmount} NRP</p>
            <form action='process_offer.php?item_id={$row['id']}' method='POST'>
                <input type='hidden' name='itemId' value='{$row['id']}'>
                <div class='price-input-wrapper'>
                    <input type='number' name='offerAmount' class='price-input' placeholder='' min='0'>
                    <span class='placeholder'>Enter your price</span>
                </div>
                <button type='submit' class='make-offer'>Make Offer</button>
            </form>
            <p>{$row['item_description']}</p>
        </div>
      </section>";
            } else {
                echo "Product not found.";
            }
        } else {
            echo "You must be logged in to view this page.";
        }
        ?>

        <div class="gallery-heading">
            <h3>Suggested to you</h3>
        </div>

        <?php include('products/list-items.php'); ?>
    </main>


    <script>
        function makeOffer(itemId, startingPrice) {
            var offerAmount = document.getElementById('offerAmount').value;

            if (offerAmount === '' || isNaN(offerAmount) || parseFloat(offerAmount) <= 0) {
                alert('Please enter a valid amount.');
                return;
            }

            if (parseFloat(offerAmount) > parseFloat(startingPrice)) {
                $.ajax({
                    type: 'POST',
                    url: 'process_offer.php',
                    data: {
                        itemId: itemId,
                        offerAmount: offerAmount
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(error) {
                        console.error('Error making offer:', error);
                    }
                });
            } else {
                alert('Offer amount must be higher than the current price.');
            }
        }
    </script>


</body>

</html>