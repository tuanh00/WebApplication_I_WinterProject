<?php
include_once 'header.php';

if (isset($_GET["user"])) {
    $username = htmlspecialchars(urldecode($_GET["user"]));
?>

    <section class="reset-password-form">
        <h2>Reset Password for <?php echo $username; ?></h2>
        <form action="includes/reset-password.inc.php" method="post">
            <input type="hidden" name="uid" value="<?php echo $username; ?>">
            <div>
                <input type="password" name="newpwd" id="newpwd" placeholder="New password..." onkeyup="validatePassword()">
                <span id="pwd-error"></span>

            </div>
            <div>
                <input type="password" name="newpwdrepeat" id="newpwdrepeat" placeholder="Repeat new password..." onkeyup="validatePassword()">
                <span id="pwdrepeat-error"></span>
            </div>
            <div>
                <button type="submit" name="reset-password" value="Reset Password">Reset Password</button>
            </div>
        </form>

        <?php

        if (isset($_GET["error"])) {
            echo "<div class='error-message'>";
            $error = $_GET["error"];
            if ($error == "emptyinput") {
                echo "<p>Please fill all fields.</p>";
            } else if ($error == "minlength") {
                echo "<p>Password must be at least 8 characters long.</p>";
            } else if ($error == "passwordsdonotmatch") {
                echo "<p>Passwords don't match.</p>";
            } else if ($error == "stmtfailed") {
                echo "<p>Something went wrong. Please try again.</p>";
            }
            echo "</div>";
        }

        ?>

    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('input').keyup(function() {
                let field = $(this).attr('name');
                if (field === 'newpwd' || field === 'newpwdrepeat') {
                    validatePassword();
                }
            });
        });

        function validatePassword() {
            let pwd = $('#newpwd').val();
            let pwdrepeat = $('#newpwdrepeat').val();

            $.ajax({
                url: 'signup_onkeyup/pwd_ajax.php',
                type: 'POST',
                data: {
                    pwd: pwd,
                    pwdrepeat: pwdrepeat
                },
                success: function(response) {
                    // Parse the JSON response
                    let data = JSON.parse(response);
                    // Update error messages
                    $('#pwd-error').text(data.pwd);
                    $('#pwdrepeat-error').text(data.pwdrepeat);
                }   
            });
        }
    </script>

<?php
}
include_once 'footer.php';
?>