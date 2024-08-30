<!DOCTYPE html>
<html>

<head>
    <title>Level 1</title>
</head>

<body>

    <?php
    include_once '../header.php';
    include_once '../includes/functions.inc.php';
    include_once '../includes/dbh.inc.php';


    // Define the level and letters if not set
    $_SESSION['current_level'] = 1;
    if (!isset($_SESSION['letters'])) {
        $_SESSION['letters'] = generateRandomLetters();
    }

    // Preserve the original sequence before sorting
    $originalSequence = $_SESSION['letters'];

    // Check for user input and process the game logic
    if (isset($_POST['guess'])) {
        $userGuess = preg_replace('/[\s,]+/', '', strtolower($_POST['guess'])); // Remove spaces and commas
        $sortedLetters = $originalSequence;
        sort($sortedLetters); // Sort the array of letters to get the correct answer
        $correctAnswer = implode('', $sortedLetters); // Convert the sorted array into a string

        checkGuess($userGuess, $correctAnswer, $originalSequence, 'level_2.php');
    }

    // Check if the user cancels the game
    if (isset($_POST['cancel'])) {
        cancelGame();
    }

    ?>

    <form action="" method="post">
        <!-- Cancel game without needing to fill guess -->
        <br>
        <button type="submit" name="cancel">Cancel Game</button>
    </form>
    <h1>Level 1</h1>
    <p>
    <h2>Arrange these letters in ascending order (Could be separated by a space or a comma): </h2>
    </p>
    <?php
    // Call the function to display error message if it exists
    displayErrorMessage();

    // Display the game form
    displayGameForm();

    include_once '../footer.php';

    ?>
</body>

</html>