<!DOCTYPE html>
<html>

<head>
    <title>Level 5</title>
</head>

<body>

    <?php
    include_once '../header.php';
    include_once '../includes/functions.inc.php';
    include_once '../includes/dbh.inc.php';

    $_SESSION['current_level'] = 5;
    if (!isset($_SESSION['letters'])) {
        $_SESSION['letters'] = generateRandomLetters();
    }

    $originalSequence = $_SESSION['letters'];

    if (isset($_POST['guess'])) {
        // Normalize the user input to handle both commas and spaces
        $input = str_replace(',', ' ', strtolower($_POST['guess']));
        $input = preg_replace('/\s+/', ' ', trim($input)); // Replace multiple spaces with a single space
        list($smallestGuess, $largestGuess) = explode(' ', $input);

        // No need to concatenate with spaces for the comparison
        $userGuess = $smallestGuess . $largestGuess;

        $sortedLetters = $originalSequence;
        sort($sortedLetters);
        $correctSmallest = reset($sortedLetters);
        $correctLargest = end($sortedLetters);
        $correctAnswer = $correctSmallest . $correctLargest; // No space between them

        checkGuess($userGuess, $correctAnswer, $originalSequence, 'level_6.php');
    }

    // Separate form for game cancellation to bypass validation
    if (isset($_POST['cancel'])) {
        cancelGame();
    }

    ?>
    <form action="" method="post">
        <!-- Cancel game without needing to fill guess -->
        <br>
        <button type="submit" name="cancel">Cancel Game</button>
    </form>

    <h1>Level 5</h1>
    <p>
    <h2>Write only the smallest letter and the largest letter (Could be separated by a space or a comma) </h2>
    </p>

    <?php

    // Call the function to display success message if it exists
    displaySuccessMessage();

    // Call the function to display error message if it exists
    displayErrorMessage();

    displayGameForm('letters');
    include_once '../footer.php';
    ?>

</body>

</html>