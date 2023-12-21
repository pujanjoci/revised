<?php
require_once(__DIR__ . '/../config.php');

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
            background-color: #ccc;
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
    </style>
    <?php require_once('config.php'); ?>
</head>

<body class="d-flex flex-column h-100 bg-light font-weight-normal">
    <header>

    </header>
    <div class="wrapper">
        <?php include "menu/sidemenu.php"; ?>
        <div id="content-container">
            <?php include "profile.php"; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Load the default content
            $('#content-container').load('profile.php');
            $('.sidebar-link').on('click', function(e) {
                e.preventDefault();

                var href = $(this).attr('href');
                $('#content-container').load(href);

                $('.sidebar-item').removeClass('active');
                $(this).closest('.sidebar-item').addClass('active');
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