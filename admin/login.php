<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
  include 'config.php';

  $username = mysqli_real_escape_string($con, $_POST['username']);
  $password = mysqli_real_escape_string($con, $_POST['password']);
  $hashedPassword = md5($password);

  $sql = "SELECT id FROM staff WHERE username=? AND password=?";
  $stmt = $con->prepare($sql);
  $stmt->bind_param("ss", $username, $hashedPassword);

  if ($stmt->execute()) {
    $stmt->bind_result($user_id);

    if ($stmt->fetch()) {
      $_SESSION["loggedin"] = true;
      $_SESSION["username"] = $username;
      $_SESSION["id"] = $user_id;

      $stmt->close();

      header("Location: index.php");
      exit();
    }
  } else {
    $error = "Invalid username or password";
    error_log($error);
    echo '<script>alert("' . $error . '");</script>';
    exit();
  }
} else {
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="icon" href="../assets/rachitlogo.png" type="image/png">
  <link rel="shortcut icon" href="../assets/rachitlogo.png" type="image/png">

  <title>Admin Login</title>
</head>

<body>
  <div class="container">
    <h2>Login</h2>
    <form id="login-form" method="POST" action="">
      <div class="input-container">
        <i class="fas fa-user"></i>
        <input type="text" id="username" name="username" placeholder="Employee-Id" required>
      </div>

      <div class="input-container">
        <i class="fas fa-lock"></i>
        <input type="password" id="password" name="password" placeholder="Password" required>
      </div>
      <button type="submit">Login</button>
    </form>


    <div class="website-link">
      <p><a href="../index.php">Go to Website</a></p>
    </div>
  </div>
</body>

</html>