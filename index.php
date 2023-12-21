<!DOCTYPE html>
<html>

<head>
    <title>Rachit Auction</title>
    <link rel="stylesheet" href="assets/header.css">
    <link rel="stylesheet" href="assets/body.css">
    <link rel="stylesheet" href="assets/intro.css">
    <link rel="stylesheet" href="assets/contactus.css">
    <link rel="stylesheet" href="assets/items.css">
    <link rel="icon" href="assets/rachitlogo.png" type="image/png">
    <link rel="shortcut icon" href="assets/rachitlogo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pacifico&display=swap">


    <script src="roll.js"></script>
    <style>
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
    </style>
</head>

<?php
session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $username = $_SESSION["username"];
    $headerText = "Hi, " . $username . " ";
    $logoutButton = '<a href="logout.php" id="logout-button"><span class="logout-icon">&#10148;</span></a>';
}
?>


<body>
    <header>
        <div id="logo">
            <a href="index.php">
                <img src="assets/logo.png" alt="Your Logo">
            </a>
        </div>

        <nav>
            <ul>
                <li><a href="#auction-listings">Auctions</a></li>
                <li><a href="#contact-us">Contact Us</a></li>
            </ul>
        </nav>

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

    <div id="intro">
        <p id="intro-statement">Welcome to our auction platform. <br>Find great deals on a wide range of items.</p>

        <?php
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            echo '<a href="register.php" id="join-us-button">Join Us</a>';
        }
        ?>
    </div>

    <div id="auction-listings" id="scroll-to-auctions">
        <div class="container">
            <div class="search-container">
                <h2>Latest items</h2>
                <div class="search-box">
                    <form id="search-form" class="search-form">
                        <div class="input-container">
                            <input type="text" id="search-bar" name="search-term" placeholder="Search...">
                            <div class="search-icon">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="items-container" id="item-container">
                <?php include('products/items.php'); ?>
            </div>
        </div>
    </div>

    </div>
    </div>


    <div id="contact-us">
        <?php include('contact.php'); ?>
    </div>

    <div id="review">

    </div>


    <script src="search.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>