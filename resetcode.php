<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Form</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        form {
            max-width: 300px;
            margin: 0 auto;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: calc(100% - 16px);
            padding: 8px;
            margin: 0 auto 16px;
            box-sizing: border-box;
            display: block;
            text-align: center;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>


<body>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2>Verification Form</h2>
            <p>Enter the 6-digit verification code sent to your email.</p>
            <label for="verificationCode">Verification Code:</label>
            <input type="text" id="verificationCode" name="verificationCode" maxlength="6" required>
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
            <button type="submit">Verify</button>
        </form>
    </div>

    <?php
    include 'config.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $verificationCode = $_POST['verificationCode'];

        try {
            $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Validate the verification code
            $sql = "SELECT * FROM forgot WHERE email = :email AND code = :code";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':code', $verificationCode, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch();

            if ($result) {
                // Code is correct
                echo "Verification successful!";
                // Redirect to changepassword.php with 'changepassword' and email in the URL
                header("Location: changepassword.php?verification=changepassword&email=" . urlencode($email));
                exit();
            } else {
                // Code is incorrect
                echo "<script>alert('Verification code not correct'); window.location='change.php';</script>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        $pdo = null;
    }
    ?>
</body>

</html>