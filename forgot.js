document.addEventListener("DOMContentLoaded", function () {
    const form1 = document.getElementById("form1");
    const form2 = document.getElementById("form2");
    const form3 = document.getElementById("form3");
    const message = document.getElementById("message");
    let userEmail;

    function showForm(show, hide1, hide2) {
        show.style.display = "block";
        hide1.style.display = "none";
        hide2.style.display = "none";
    }

    document.getElementById("sendCode").addEventListener("click", function () {
        const email = document.getElementById("email").value;
        userEmail = email;

        // Show the second form and hide the first form
        showForm(form2, form1, form3);
    });

    document.getElementById("verifyCode").addEventListener("click", function () {
        const resetCode = document.getElementById("resetCode").value;

        // Check if the reset code matches (see PHP code)

        if (resetCodeMatches) {
            showForm(form3, form1, form2);
            message.innerHTML = "";
        } else {
            message.innerHTML = "Invalid reset code.";
        }
    });

    document.getElementById("updatePassword").addEventListener("click", function () {
        const newPassword = document.getElementById("newPassword").value;
        const confirmPassword = document.getElementById("confirmPassword").value;

        if (newPassword !== confirmPassword) {
            message.innerHTML = "Passwords do not match.";
            return;
        }


        if (passwordUpdated) {
            showForm(form1, form2, form3);
            message.innerHTML = "Password updated successfully.";
            setTimeout(function () {
                message.innerHTML = "";
            }, 5000);
        } else {
            message.innerHTML = "Password update failed.";
        }
    });
});
