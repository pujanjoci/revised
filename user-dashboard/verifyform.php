<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code</title>
    <style>
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        .email-input {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 10px;
        }

        .email-input input {
            margin: 5px;
            padding: 10px;
            width: 250px;
            text-align: center;
        }

        .verification-code input {
            margin: 5px;
            padding: 10px;
            width: 30px;
            text-align: center;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="text"] {
            width: 30px;
            text-align: center;
        }
    </style>
</head>

<body>
    <form action="verify.php" method="post">
        <div class="email-input">
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="verification-code">
            <input type="text" name="digit1" maxlength="1" pattern="[0-9]" required onkeyup="focusNext(this, 'digit2')">
            <input type="text" name="digit2" maxlength="1" pattern="[0-9]" required onkeyup="focusNext(this, 'digit3')">
            <input type="text" name="digit3" maxlength="1" pattern="[0-9]" required onkeyup="focusNext(this, 'digit4')">
            <input type="text" name="digit4" maxlength="1" pattern="[0-9]" required onkeyup="focusNext(this, 'digit5')">
            <input type="text" name="digit5" maxlength="1" pattern="[0-9]" required onkeyup="focusNext(this, 'digit6')">
            <input type="text" name="digit6" maxlength="1" pattern="[0-9]" required>
        </div>
        <button type="submit">Verify Code</button>
    </form>

    <form action="resend.php" method="post">
        <button type="submit" name="resend_code">Re-send code</button>
    </form>

    <script>
        function focusNext(current, nextInputName) {
            if (current.value.length === current.maxLength) {
                document.getElementsByName(nextInputName)[0].focus();
            }
        }
    </script>
</body>

</html>