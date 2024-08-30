<!DOCTYPE html>
<html>

<head>
    <title>Level 2</title>
</head>

<body>

    <?php
    include_once '../header.php';
    include_once '../includes/functions.inc.php';
    include_once '../includes/dbh.inc.php';

    $_SESSION['current_level'] = 2;
    if (!isset($_SESSION['letters'])) {
        $_SESSION['letters'] = generateRandomLetters();
    }

    $originalSequence = $_SESSION['letters'];

    if (isset($_POST['guess'])) {
        $userGuess = preg_replace('/[\s,]+/', '', strtolower($_POST['guess'])); // Remove spaces and commas
        $sortedLetters = $originalSequence;
        rsort($sortedLetters);
        $correctAnswer = implode('', $sortedLetters); // Convert the sorted array into a string

        checkGuess($userGuess, $correctAnswer, $originalSequence, 'level_3.php');
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

    <h1>Level 2</h1>
    <p>
    <h2>Arrange these letters in descending order (Could be separated by a space or a comma): </h2>
    </p>

    <?php

    // Call the function to display success message if it exists
    displaySuccessMessage();
    
    // Call the function to display error message if it exists
    displayErrorMessage();

    displayGameForm();
    include_once '../footer.php'; // Include this if needed for HTML structure
    ?>

</body>

</html>