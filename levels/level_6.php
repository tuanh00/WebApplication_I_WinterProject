<!DOCTYPE html>
<html>

<head>
    <title>Level 6</title>
</head>

<body>

    <?php
    include_once '../header.php';
    include_once '../includes/functions.inc.php';
    include_once '../includes/dbh.inc.php';


    $_SESSION['current_level'] = 6;
    if (!isset($_SESSION['numbers'])) {
        $_SESSION['numbers'] = generateRandomNumbers();
    }

    $originalSequence = $_SESSION['numbers'];


    if (isset($_POST['guess'])) {
        // Normalize the user input to handle both commas and spaces
        $input = str_replace(',', ' ', $_POST['guess']);
        $input = preg_replace('/\s+/', ' ', trim($input)); // Replace multiple spaces with a single space
        list($smallestGuess, $largestGuess) = array_map('intval', explode(' ', $input));

        // Sort the session numbers for the correct answer
        $sortedNumbers = $originalSequence;
        sort($sortedNumbers); // Sort for correct answer
        $correctSmallest = reset($sortedNumbers);
        $correctLargest = end($sortedNumbers);

        // Concatenate the smallest and largest for comparison without spaces
        $correctAnswer = $correctSmallest . $correctLargest;

        // User guess should be a string with the two numbers concatenated
        $userGuess = $smallestGuess . $largestGuess;

        checkGuess($userGuess, $correctAnswer, $originalSequence, '../game_result.php?gameresult=win');
    }

    if (isset($_POST['cancel'])) {
        cancelGame();
    }

    ?>
    <form action="" method="post">
        <!-- Cancel game without needing to fill guess -->
        <br>
        <button type="submit" name="cancel" class="cancel-button">Cancel Game</button>
    </form>

    <h1>Final Level - Level 6</h1>
    <p>
    <h2>Write only the smallest number and the largest number (Could be separated by a space or a comma) </h2>
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