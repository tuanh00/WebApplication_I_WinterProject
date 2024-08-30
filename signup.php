<?php
include_once 'header.php';

?>

<section class="signup-form">
    <h2>Sign Up</h2>

    <!-- .inc means include file -->
    <!-- method=post: b/c we don't want data in the URL -->
    <form action="includes/signup.inc.php" method="post">
        <div>
            <input type="text" name="fname" id="fname" placeholder="First name..." onkeyup="validateInput('fname',this.value)">
            <span id="fname-error"></span>
        </div>

        <div>
            <input type="text" name="lname" id="lname" placeholder="Last name..." onkeyup="validateInput('lname',this.value)">
            <span id="lname-error"></span>
        </div>

        <div>
            <input type="text" name="uid" id="uid" placeholder="Username..." onkeyup="validateInput('uid',this.value)">
            <span id="uid-error"></span>
        </div>

        <div>
            <input type="password" name="pwd" id="pwd" placeholder="Password..." onkeyup="validatePassword()">
            <span id="pwd-error"></span>
        </div>

        <div>
            <input type="password" name="pwdrepeat" id="pwdrepeat" placeholder="Repeat password..." onkeyup="validatePassword()">
            <span id="pwdrepeat-error"></span>

        </div>
        <div>
            <button type="submit" name="signup" value="Sign Up">Sign Up</button>
        </div>
    </form>
    <!-- Display error message corresponding to error in URL -->
    <?php
    if (isset($_GET["error"])) {
        echo "<div class='error-message'>";
        $error = $_GET["error"];
        if ($error == "emptyinput") {
            echo "<p>Please fill all fields.</p>";
        } else if ($error == "invalidinput_startwithletter") {
            echo "<p>First name, last name, and username must start with a letter.</p>";
        } else if ($error == "minlength") {
            echo "<p>Username and password must be at least 8 characters long.</p>";
        } else if ($error == "passwordnotmatch") {
            echo "<p>Passwords don't match.</p>";
        } else if ($error == "usernametaken") {
            echo "<p>Username already taken.</p>";
        }
        echo "</div>";
    }
    // Display success message if user has successfully signed up
    if (isset($_GET["error"])) {
        $error = $_GET["error"];
        if ($error == "none") {
            echo "<div class='success-message'>";
            echo "<p>Sign up successful!</p>";
            echo "</div>";
        }
    }
    ?>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('input').keyup(function() {
            let field = $(this).attr('name');
            let value = $(this).val();
            if (field === 'pwd' || field === 'pwdrepeat') {
                validatePassword();
            } else {
                validateInput(field, value);
            }
        });
    });

    function validateInput(field, value) {
        $.ajax({
            url: 'signup_onkeyup/' + field + '_ajax.php',
            type: 'POST',
            data: {
                value: value
            },
            success: function(response) {
                $('#' + field + '-error').text(response);
            }
        });
    }

    function validatePassword() {
        let pwd = $('#pwd').val();
        let pwdrepeat = $('#pwdrepeat').val();

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
include_once 'footer.php';
?>