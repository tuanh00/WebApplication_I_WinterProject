<?php
include_once 'header.php';
?>


<section class="login-form">
    <h2>Login</h2>

    <!-- .inc means include file -->
    <!-- method=post: b/c we don't want data in the URL -->
    <form action="includes/login.inc.php" method="post">
        <div>
            <input type="text" name="uid" placeholder="Username...">
        </div>

        <div>
            <input type="password" name="pwd" placeholder="Password...">
        </div>

        <div>
            <button type="submit" name="login" value="Login">Login</button>
        </div>
    </form>

    <!-- Display error message corresponding to error in URL -->
    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] != "signupsuccessful") {
            echo "<div class='error-message'>";
            // Handle different error cases
            switch ($_GET["error"]) {
                case "accessdenied":
                    echo "<p>Access denied. Please login first.</p>";
                    break;
                case "emptyinput":
                    echo "<p>Please fill all fields.</p>";
                    break;
                case "stmtfailed":
                    echo "<p>Something went wrong. Please try again.</p>";
                    break;
                case "wronglogin":
                    $user = htmlspecialchars(urlencode($_GET["user"]));
                    echo "<p>Incorrect login information! <a href='reset-password.php?user={$user}'>Forgot your password?</a></p>";
                    break;
                case "nouser":
                    echo "<p>Username does not exist. <a href='signup.php'>Please register first.</a></p>";
                    break;
            }
            echo "</div>";
        }
    }

     // Display a success message if user has successfully signed up
     if (isset($_GET["error"]) && $_GET["error"] == "signupsuccessful") {
        echo "<div class='success-message'><p>Sign up successful! Please login.</p></div>";
    }
    
    // Display success message if user has successfully reset their password
    if (isset($_GET["newpwd"])) {
        echo "<div class='success-message'>";
        echo "<p>Password reset successful. Please login.</p>";
        echo "</div>";
    }



   
    ?>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

</script>



<?php
include_once 'footer.php';
?>