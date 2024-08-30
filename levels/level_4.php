<!DOCTYPE html>
<html>

<head>
    <title>Level 4</title>
</head>

<body>

    <?php
    include_once '../header.php';
    include_once '../includes/functions.inc.php';
    include_once '../includes/dbh.inc.php';

    //ensureLoggedIn();

    $_SESSION['current_level'] = 4;
    if (!isset($_SESSION['numbers'])) {
        $_SESSION['numbers'] = generateRandomNumbers(); // No need to sort, comparison will be done in checkGuess
    }

    $originalSequence = $_SESSION['numbers'];


    if (isset($_POST['guess'])) {
        // Allow numbers to be separated by either a comma or space
        $userGuess = preg_replace('/\s+/', ' ', trim($_POST['guess'])); // Replace multiple spaces with a single space
        $userGuess = str_replace(',', ' ', $userGuess);
        $guess = array_map('intval', explode(' ', $userGuess));
        //rsort($guess); // Sort the numbers in descending order

        $correctAnswer = $originalSequence;
        rsort($correctAnswer); // Sort the correct answer in descending order

        // Convert both to strings without spaces for comparison
        $userGuessString = implode('', $guess);
        $correctAnswerString = implode('', $correctAnswer);

        checkGuess($userGuessString, $correctAnswerString, $originalSequence, 'level_5.php'); // Redirect to next level or winning page
    }


    if (isset($_POST['cancel'])) {
        cancelGame();
    }

    ?>
    <form action="" method="post">
        <!-- Cancel game without needing to fill guess -->
        <br>
        <button type="submit" name="cancel">Cancel Game</button>
    </form>

    <h1>Level 4</h1>
    <p>
    <h2>Arrange these numbers in descending order (Could be separated by a space or a comma): </h2>
    </p>

    <?php

    // Call the function to display success message if it exists
    displaySuccessMessage();
    
    // Call the function to display error message if it exists
    displayErrorMessage();

    displayGameForm('numbers');
    include_once '../footer.php';
    ?>

</body>

</html>