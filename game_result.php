<?php
include_once 'header.php';
include_once 'includes/functions.inc.php';
include_once 'includes/dbh.inc.php';

// Determine the game result based on the 'gameresult' query parameter
$gameResult = isset($_GET['gameresult']) ? $_GET['gameresult'] : 'win';

// Save the game result to the database
if(isset($_SESSION['registrationOrder']) && isset($gameResult)) {
    // Assuming that 'win' or 'gameover' is passed as the $gameResult
    saveGameResult($gameResult, $_SESSION['lives']);
    // Then unset the game session variables
    unset($_SESSION['lives'], $_SESSION['letters'], $_SESSION['numbers'], $_SESSION['current_level']);
}

$title = 'Congratulations!';
$message = 'You have successfully completed all the levels!';
$backgroundColor = '#d4edda'; // Success background color
$buttonMessage = 'Play Again';

if ($gameResult === 'gameover') {
    $title = 'Game Over';
    $message = 'You ran out of lives. Better luck next time!';
    $backgroundColor = '#f2dede'; // Error background color
    $buttonMessage = 'Try Again';
    $_SESSION['lives'] = 6; // Reset lives for a new game.
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game Result</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Your existing CSS file -->
    <style>
        /* Additional styles */
        .game-result {
            text-align: center;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-top: 50px;
        }
        .game-result h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        .game-result p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }
        .game-result a {
            text-decoration: none;
            color: #ffffff;
            background-color: #007bff;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .game-result a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="game-result" style="background-color: <?php echo $backgroundColor; ?>;">
            <h1><?php echo $title; ?></h1>
            <p><?php echo $message; ?></p>
             <!-- Container for button and image -->
        <div style="display: flex; justify-content: center; align-items: center;">
            <a href="levels/level_1.php" class="button"><?php echo $buttonMessage; ?></a>
            <!-- GIF next to the button -->
            <img src="http://localhost/dw3/img/try_again_pochacco.gif" alt="Try Again" style="margin-left: 10px; width: 50px; height: auto;">
        </div>
        </div>
    </div>
</body>
</html>
