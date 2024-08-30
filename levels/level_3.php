<!DOCTYPE html>
<html>

<head>
    <title>Level 3</title>
</head>

<body>

    <?php
    include_once '../header.php';
    include_once '../includes/functions.inc.php';
    include_once '../includes/dbh.inc.php';

    $_SESSION['current_level'] = 3;
    if (!isset($_SESSION['numbers'])) {
        $_SESSION['numbers'] = generateRandomNumbers(); // For ascending order numbers
    }

    $originalSequence = $_SESSION['numbers'];


    if (isset($_POST['guess'])) {

        //----- Allow numbers to be separated by either a comma or space -----
        $userGuess = preg_replace('/\s+/', ' ', trim($_POST['guess'])); // Replace multiple spaces with a single space
        $userGuess = str_replace(',', ' ', $userGuess); // Replace commas with spaces
        $guess = array_map('intval', explode(' ', $userGuess)); // Split into an array
        //sort($guess); // Sort the numbers in ascending order

        $correctAnswer = $originalSequence;
        sort($correctAnswer); // Sort the correct answer in ascending order

        // Convert both to strings without spaces for comparison
        $userGuessString = implode('', $guess);
        $correctAnswerString = implode('', $correctAnswer);

        checkGuess($userGuessString, $correctAnswerString, $originalSequence, 'level_4.php'); // Redirect to next level or winning page
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

    <h1>Level 3</h1>
    <p>
    <h2>Arrange these numbers in ascending order (Could be separated by a space or a comma): </h2>
    </p>
    <?php

    // Call the function to display success message if it exists
    displaySuccessMessage();
    
    // Call the function to display error message if it exists
    displayErrorMessage();

    displayGameForm('numbers');
    include_once '../footer.php'; // Include this if needed for HTML structure
    ?>

</body>

</html>