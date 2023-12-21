<?php require_once('config.php'); ?>
<?php require_once('menu/authsesion.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://kit.fontawesome.com/f32fbc8f37.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="icon" href="../assets/rachitlogo.png" type="image/png">
    <link rel="shortcut icon" href="../assets/rachitlogo.png" type="image/png">
</head>

<body>
    <?php
    // Redirect to profile/index.php
    header('Location: profile/index.php');
    exit();
    ?>
</body>

</html>