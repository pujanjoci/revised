<!DOCTYPE html>
<html>

<head>
    <title>Rachit Auction</title>
    <link rel="stylesheet" type="text/css" href="../assets/header.css">
    <link rel="stylesheet" type="text/css" href="../assets/body.css">
    <link rel="stylesheet" type="text/css" href="../assets/intro.css">
    <link rel="stylesheet" type="text/css" href="../assets/items.css">
    <link rel="stylesheet" type="text/css" href="../assets/contact.css">
    <link rel="icon" href="../assets/rachitlogo.png" type="image/png">
    <link rel="shortcut icon" href="../assets/rachitlogo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />


    <script src="roll.js"></script>
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
            <a href="dashboard.php">
                <img src="../assets/logo.png" alt="Your Logo">
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
            echo '<div id="user-info">';
            echo $headerText;
            echo '</div>';
            echo '<div id="logout-button">';
            echo $logoutButton;
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
                <?php include('../products/items.php'); ?>
            </div>
        </div>
    </div>

    </div>
    </div>

    <div id="contact-us">
        <div class="contact-info">
            <h2>Contact Information</h2>
            <p>Email: rachitauction@gmail.com</p>
            <p>Phone: (+977) 9800000000</p>
            <p>Address: Suryabinayak, Bhaktapur, Nepal</p>
        </div>
        <div class="contact-form">
            <h2>Form</h2>
            <form action="#" method="post">
                <div class="input-block">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="input-block">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-block">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="4" required></textarea>
                </div>
                <div class="input-block">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>

    <script src="search.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>