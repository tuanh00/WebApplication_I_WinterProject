<?php

if (isset($_POST["login"])) {

    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];

    require_once 'dbh.inc.php';     // Error handlers and database connection
    require_once 'functions.inc.php'; //

    if (emptyInput($username, $pwd) !== false) {
        header("location: ../login.php?error=emptyinput"); // Redirect to login page with error message
        exit(); // Stop the script from running
    }


    loginUser($conn, $username, $pwd);
} else {
    header("location: ../login.php?error=accessdenied");
}
