<?php
include_once 'includes/dbh.inc.php';
include_once 'includes/functions.inc.php';

session_start();


// Check if "last activity" is set and user is logged in
if (isset($_SESSION['username']) && isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 900)) { //900 seconds means 15 minutes
    if (isset($_SESSION['lives']) && $_SESSION['lives'] > 0) {
        saveGameResult('incomplete', $_SESSION['lives']);
    }
    // Last request was more than 15 minutes ago
    session_unset();     // unset $_SESSION variable
    session_destroy();   // destroy session data
    header("Location: ../index.php"); //*****Indicate error session out 
    exit();
}

$_SESSION["last_activity"] = time(); // Set the last activity to current time on login

$baseUrl = 'http://localhost/dw3/'; // CHANGE DEPENDING ON YOUR MACHINE

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Homepage</title>
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>css/main.css" type="text/css">
    <!-- <script src="js/main.js"></script> -->

</head>

<body>

    <nav>
        <div class="wrapper">
            <ul>
                <li><a href="<?php echo $baseUrl; ?>index.php"><img src="<?php echo $baseUrl; ?>img/logo_pochacco.png" alt="Kids' World of Fun Logo"></a></li>
                <li><a href="<?php echo $baseUrl; ?>index.php">Home</a></li>
                <li><a href="<?php echo $baseUrl; ?>about.php">About</a></li>
                <?php if (!isset($_SESSION['username'])) : ?>
                    <li><a href="<?php echo $baseUrl; ?>signup.php">Sign up</a></li>
                    <li><a href="<?php echo $baseUrl; ?>login.php">Log in</a></li>
                <?php else : ?>
                    <li><a href="<?php echo $baseUrl; ?>game_history.php">Game History</a></li>
                    <li><a href="<?php echo $baseUrl; ?>levels/level_1.php">Play Game</a></li>
                    <li><a href="<?php echo $baseUrl; ?>logout.php">Log out</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="wrapper">