<?php

if (isset($_POST["reset-password"])) {

    $username = $_POST["uid"];
    $newPwd = $_POST["newpwd"];
    $newPwdRepeat = $_POST["newpwdrepeat"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInput($username, $newPwd, $newPwdRepeat) !== false) {
        header("location: ../reset-password.php?error=emptyinput&user=".urlencode($username));
        exit();
    }

    if (!isMinLength($newPwd) || !isMinLength($newPwd)) {
        header("location: ../reset-password.php?error=minlength&user=".urlencode($username));
        exit();
    }

    if (!pwdMatch($newPwd, $newPwdRepeat)) {
        header("location: ../reset-password.php?error=passwordsdonotmatch&user=".urlencode($username));
        exit();
    }

    //-----Proceed with updating the user's password-----
    updateUserPassword($conn, $username, $newPwd);
    header("location: ../login.php?newpwd=success");  // Redirect to login page with success message


} else {
    header("location: ../reset-password.php"); // Redirect to reset-password page if user tries to access this page without submitting the form
    exit();
}
