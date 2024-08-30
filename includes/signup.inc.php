<?php

if (isset($_POST["signup"])) {

    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdrepeat = $_POST["pwdrepeat"];

    require_once 'dbh.inc.php';     // Error handlers and database connection
    require_once 'functions.inc.php'; //

    if (emptyInput($fname, $lname, $username, $pwd, $pwdrepeat) !== false) {
        header("location: ../signup.php?error=emptyinput"); // Redirect to signup page with error message
        exit(); // Stop the script from running
    }

    if (!startsWithLetter($fname) || !startsWithLetter($lname) || !startsWithLetter($username)) {
        header("location: ../signup.php?error=invalidinput_startwithletter");
        exit();
    }

    if (!isMinLength($username) || !isMinLength($pwd)) {
        header("location: ../signup.php?error=minlength");
        exit();
    }


    if (!pwdMatch($pwd, $pwdrepeat)) {
        header("location: ../signup.php?error=passwordnotmatch");
        exit();
    }

    //connect the database to check if the username already exists
    if (isUsernameUnique($conn, $username) !== false) {
        header("location: ../signup.php?error=usernametaken");
        exit();
    }

    // If the code reaches here means the username is unique, and we can proceed to create the user
    createUser($conn, $fname, $lname, $username, $pwd);
} else {
    header("location: ../signup.php"); // Redirect to signup page
}
