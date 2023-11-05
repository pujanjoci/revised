<?php
require('config.php');

$username = isset($_SESSION['username']) ? $_SESSION['username'] : "";
$email = "";

if (!empty($username)) {
    $sql = "SELECT email FROM users WHERE username = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();
}
?>

<body>
    <div class="contact-container">
        <div class="contact-content">
            <div class="contact-left-side">
                <div class="contact-address contact-details">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="contact-topic">Address</div>
                    <div class="contact-text-one">Surkhet, NP12</div>
                    <div class="contact-text-two">Birendranagar 06</div>
                </div>
                <div class="contact-phone contact-details">
                    <i class="fas fa-phone-alt"></i>
                    <div class="contact-topic">Phone</div>
                    <div class="contact-text-one">+0098 9893 5647</div>
                    <div class="contact-text-two">+0096 3434 5678</div>
                </div>
                <div class="contact-email contact-details">
                    <i class="fas fa-envelope"></i>
                    <div class="contact-topic">Email</div>
                    <div class="contact-text-one">rachitauction@gmail.com</div>
                    <div class="contact-text-two">new email comming soon</div>
                </div>
            </div>
            <div class="contact-right-side">
                <div class="contact-topic-text">Leave Review</div>
                <form action="message.php" method="post" id="contact-form">
                    <div class="contact-input-box">
                        <input type="text" name="name" placeholder="Enter your name" value="<?php echo htmlspecialchars($username); ?>">
                    </div>
                    <div class="contact-input-box">
                        <input type="text" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($email); ?>">
                    </div>
                    <div class="contact-input-box contact-message-box">
                        <textarea placeholder="Enter your review" name="message"></textarea>
                        <span id="description-counter"></span>
                    </div>
                    <div class="contact-button">
                        <input type="button" value="Send Now" onclick="validateForm()">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function validateForm() {
            var nameInput = document.forms["contact-form"]["name"];
            var emailInput = document.forms["contact-form"]["email"];
            var messageInput = document.forms["contact-form"]["message"];


            if (nameInput.value === "" || messageInput.value === "") {
                alert("All Input fields are required .");
                return false;
            }
            document.getElementById("contact-form").submit();
        }

        function limitMessage(textarea, maxLength) {
            var message = textarea.value;
            var messageLength = message.length;

            if (messageLength > maxLength) {
                textarea.value = message.substring(0, maxLength);
                messageLength = maxLength;
            }

            var charactersRemaining = maxLength - messageLength;
            var counterText = charactersRemaining + " characters remaining";

            document.getElementById("description-counter").textContent = counterText;
        }
    </script>
</body>