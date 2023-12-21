<?php
require_once(__DIR__ . '../config.php');

session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
} else {
    header('Location: ../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://kit.fontawesome.com/f32fbc8f37.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="menu/style.css">
    <link rel="icon" href="../../assets/rachitlogo.png" type="image/png">
    <link rel="shortcut icon" href="../../assets/rachitlogo.png" type="image/png">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #212529;
            /* Dark background color */
            color: #fff;
        }

        .wrapper {
            display: flex;
            height: 100vh;
        }

        #sidebar {
            width: 250px;
            background-color: rgba(31, 36, 47, 0.961);
            box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.433);
            z-index: 1000;
        }

        #content-container {
            flex-grow: 1;
            overflow: auto;
            padding: 20px;
        }

        @media (max-width: 768px) {
            #sidebar {
                width: 100%;
                position: fixed;
                z-index: 1000;
                height: 100%;
                overflow-y: auto;
                transition: all 0.35s ease-in-out;
            }

            #content-container {
                margin-left: 0;
            }

            #sidebar.collapsed {
                margin-left: -100%;
            }
        }

        /* Professional form styling */
        #item-form {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        #item-form h2 {
            font-size: 24px;
            margin-bottom: 30px;
            text-align: center;
            color: #212529;
            /* Dark text color */
        }

        #item-form label {
            font-weight: bold;
            color: #212529;
            /* Dark text color */
        }

        #item-form input,
        #item-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            /* Bootstrap default input border color */
            border-radius: 5px;
            color: #495057;
            /* Bootstrap default input text color */
        }

        #item-form button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        #item-form button:hover {
            background-color: #0056b3;
        }

        /* Button for redirecting to index.php */
        #redirect-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 10px;
        }

        #redirect-btn:hover {
            background-color: #0056b3;
        }
    </style>
    <?php require_once('config.php'); ?>
</head>

<body class="d-flex flex-column h-100 bg-light font-weight-normal">
    <header>

    </header>
    <div class="wrapper">
        <?php include "menu/sidemenu.php"; ?>
        <div id="content-container">
            <button id="redirect-btn" onclick="location.href='index.php'">All items</button>
            <form id="item-form" action="process_add_item.php" method="post">
                <h2>Add Item</h2>
                <label for="item_name">Item Name:</label>
                <input type="text" name="item_name" required>

                <label for="item_description">Item Description:</label>
                <textarea name="item_description" rows="4" required></textarea>

                <label for="item_image">Item Image URL:</label>
                <input type="text" name="item_image" required>

                <label for="starting_price">Starting Price:</label>
                <input type="number" name="starting_price" required>

                <label for="end_time">End Time:</label>
                <input type="datetime-local" name="end_time" required>

                <label for="seller">Seller:</label>
                <input type="text" name="seller" required>

                <button type="submit">Add Item</button>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Commented out the line to prevent automatic loading of items.php on page load
            // $('#content-container').load('items.php');

            // Function to load content when a sidebar link is clicked
            function loadContent(href) {
                $('#content-container').load(href);
                $('.sidebar-item').removeClass('active');
                $('.sidebar-link[href="' + href + '"]').closest('.sidebar-item').addClass('active');
            }

            // Load default content when the page loads (you can modify this link)
            loadContent('default.php');

            // Attach click event to sidebar links
            $('.sidebar-link').on('click', function(e) {
                e.preventDefault();
                var href = $(this).attr('href');
                loadContent(href);
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Check for the success or error parameters in the URL
            const urlParams = new URLSearchParams(window.location.search);
            const successMessage = urlParams.get('success');
            const errorMessage = urlParams.get('error');

            // Display an alert if the success message is present
            if (successMessage) {
                alert(successMessage);
                // Remove the success parameter after 2 seconds
                setTimeout(function() {
                    history.replaceState({}, document.title, window.location.pathname);
                }, 1000);
            }

            // Display an alert if the error message is present
            if (errorMessage) {
                alert(errorMessage);
                // Remove the error parameter after 2 seconds
                setTimeout(function() {
                    history.replaceState({}, document.title, window.location.pathname);
                }, 1000);
            }
        });
    </script>

</body>

</html>