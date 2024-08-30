<?php

require_once 'dbh.inc.php';

function emptyInput(...$inputs) // Use variadic parameters
{
    foreach ($inputs as $input) {
        if (empty($input)) {
            return true;
        }
    }
    return false;
}

//-----------------SIGNUP FUNCTIONS----------------
function startsWithLetter($data)
{
    return preg_match('/^[a-zA-Z]/', $data);
}

function isMinLength($data)
{
    return strlen($data) >= 8;
}

function pwdMatch($pwd, $pwdRepeat)
{
    return $pwd === $pwdRepeat;
}

function isUsernameUnique($conn, $username)
{
    $sql = "SELECT * FROM player WHERE userName = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $username); //second parameter is the data type of the variable
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt); //wrap the result in a variable
    if ($row = mysqli_fetch_assoc($resultData)) { //fetch the data associated with the $resultData. 1:17:56

        return $row; //return user information when the username already exists

    } else {
        return false; //return false when the username does not exist
    }

    mysqli_stmt_close($stmt); //close the statement
}

function createUser($conn, $fname, $lname, $username, $pwd)
{
    // First, insert the user into the 'player' table
    $sql = "INSERT INTO player (fName, lName, userName, registrationTime) VALUES (?, ?, ?, NOW());";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $fname, $lname, $username); //'sss' because we have 3 parameters as strings
    mysqli_stmt_execute($stmt);

    // retrieve the registrationOrder of the last inserted user
    $registrationOrder = mysqli_insert_id($conn);

    // Hash the password 
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    // insert the hashed password into the 'authenticator' table
    $sql = "INSERT INTO authenticator (passCode, registrationOrder) VALUES (?, ?);";
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "si", $hashedPwd, $registrationOrder); //si means string and integer
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    // At this point, both the player and their authenticator record have been inserted
    // Redirect or proceed as necessary 
    header("location: ../login.php?error=signupsuccessful"); //error==signupsuccessful means create user successfully
}

//----------LOGIN FUNCTION----------------
function getUserByUsername($conn, $username)
{
    $sql = "SELECT p.*, a.passCode FROM player p INNER JOIN authenticator a ON p.registrationOrder = a.registrationOrder WHERE p.userName = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row; //return user information when the username already exists
    } else {
        return false; //return false when the username does not exist
    }

    mysqli_stmt_close($stmt);
}

// Login the user if the username and password match
function loginUser($conn, $username, $pwd)
{
    $uidExists = getUserByUsername($conn, $username);

    // Scenario when username doesn't exist redirect to login page with error message
    if ($uidExists === false) {
        header("location: ../login.php?error=nouser");
        exit();
    }

    // Scenario when username exists but password is incorrect redirect to login page with error message
    $passCode = $uidExists["passCode"];
    $checkPwd = password_verify($pwd, $passCode);

    if ($checkPwd === false) {
        header("location: ../login.php?error=wronglogin&user=" . urlencode($username));
        exit();
    }

    // Scenario when username and password are correct, proceed with login
    session_start();
    $_SESSION["username"] = $uidExists["userName"]; /*This line sets a session variable named username. Session variables are used to store information about a user's session. Here it is storing the username of the user that has just logged in */
    $_SESSION["registrationOrder"] = $uidExists["registrationOrder"];
    $_SESSION["last_activity"] = time(); // Set the last activity to current time on login
    $_SESSION['lives'] = 6; // Set the number of lives for the user after logging in successfully

    header("location: ../levels/level_1.php");
    exit();
}

function updateUserPassword($conn, $username, $newPwd)
{
    $sql = "UPDATE authenticator a INNER JOIN player p ON a.registrationOrder = p.registrationOrder SET a.passCode = ? WHERE p.userName = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../login.php?error=stmtfailed"); //*****haven't handle this error yet
        exit();
    }

    $hashedPwd = password_hash($newPwd, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ss", $hashedPwd, $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

//-----------------GAME FUNCTIONS----------------
// Shared game logic for all levels
function saveGameResult($result, $livesUsed)
{
    global $conn; // This will make the $conn available inside this function
    $sql = "INSERT INTO score (scoreTime, result, livesUsed, registrationOrder) VALUES (NOW(), ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        $registrationOrder = $_SESSION["registrationOrder"]; // Retrieved from session
        mysqli_stmt_bind_param($stmt, "sii", $result, $livesUsed, $registrationOrder);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "Error saving game result.";
    }
}

function checkGuess($userGuess, $correctAnswer, $originalSequence, $redirectTo)
{
    // Convert userGuess and correctAnswer to arrays for comparison
    $userGuessArray = str_split($userGuess);
    $correctAnswerArray = str_split($correctAnswer);

    if ($userGuess === $correctAnswer) {
        $_SESSION['successMessage'] = "Congratulations! You successfully completed the level. Moving to the next one..."; // Set a success message
        header("location: $redirectTo");
        exit();
    } else {
        $_SESSION['lives']--;
        if ($_SESSION['lives'] <= 0) {
            // Correctly calculate lives used for game over scenario
            //saveGameResult('gameover', 6);
            //unset($_SESSION['lives'], $_SESSION['letters'], $_SESSION['numbers'], $_SESSION['current_level']);
            $_SESSION['lives'] = 6; //means the user lost all lives
            header("location: ../game_result.php?gameresult=gameover");
            exit();
        } else {
            //header("location: {$_SERVER['PHP_SELF']}?error=wrongguess");
            //error_log("Debug - User guess: {$userGuess} | Correct Answer: {$correctAnswer} | Lives: " . $_SESSION['lives']);
            // Redirect back to the same level with an error
            //header("location: {$_SERVER['PHP_SELF']}?error=wrongguess&lives=" . $_SESSION['lives'] . "&correctguess=" . urlencode($correctAnswer) . "&userguess=" . urlencode($userGuess));

            $errorType = evaluateUserGuess($userGuessArray, $correctAnswerArray, $originalSequence);
            header("location: {$_SERVER['PHP_SELF']}?error=$errorType&lives=" . $_SESSION['lives'] . "&correctguess=" . urlencode($correctAnswer) . "&userguess=" . urlencode($userGuess));

            exit();
        }
    }
}

function generateRandomLetters()
{
    $letters = range('a', 'z'); // or use range('A', 'Z') for uppercase
    shuffle($letters);
    return array_slice($letters, 0, 6);
}

function generateRandomNumbers()
{
    $numbers = range(0, 100);
    shuffle($numbers);
    return array_slice($numbers, 0, 6);
}

// HTML form for the game, call this function where the form is needed
function displayGameForm($guessType = 'letters')
{
    // Check if 'lives' is set in the session, if not, set a default value
    if (!isset($_SESSION['lives'])) {
        $_SESSION['lives'] = 6; // Default number of lives
    }

    echo "<br><h2>Lives Remaining: " . $_SESSION['lives'] . "</h2><br>"; // Display lives within the form function
    $valuesToOrder = $guessType === 'letters' ? $_SESSION['letters'] : $_SESSION['numbers'];
    //echo "<h2>Arrange these {$guessType} in order:</h2>";
    echo "<p>" . implode(' ', $valuesToOrder) . "</p>";
    echo "<form action='' method='post'>";
    echo "<input type='text' name='guess' required>";
    echo "<button type='submit'>Submit</button>";
    echo "</form>";
}


function cancelGame()
{
    if ($_SESSION['lives'] > 0) {
        saveGameResult('incomplete', $_SESSION['lives']);
    }
    unset($_SESSION['lives'], $_SESSION['letters'], $_SESSION['numbers'], $_SESSION['current_level']);
    header("Location: ../index.php");
    exit();
}

function displayErrorMessage() {
    if (isset($_GET['error'])) {
        $errorMsg = "Incorrect guess! ";
        switch ($_GET['error']) {
            case 'all-different':
                $errorMsg .= " All your numbers/letters are different from ours";
                break;
            case 'some-different':
                $errorMsg .= " Some of your numbers/letters are different from ours";
                break;
            case 'incorrect-order':
                $errorMsg .= " Your numbers/letters were not correctly arranged";
                break;
        }
        // Add an image tag at the end of the message
        echo '<p class="error-message">';
        echo htmlspecialchars($errorMsg) . " &ensp;"; 
        echo '<img src="http://localhost/dw3/img/fail_pochacco.gif" alt="Error" style="width:50px; height:auto; margin-left:10px; vertical-align:middle;">';
        echo '</p>';
    }
}

function displaySuccessMessage()
{
    if (isset($_SESSION['successMessage'])) {
        // Update the message to include the image tag
        echo '<p class="success-message">';
        echo htmlspecialchars($_SESSION['successMessage']);
        echo '<img src="http://localhost/dw3/img/success_all_lvl_pochacco.gif" alt="Success" style="width:50px;height:auto;margin-right:10px;margin-bottom:10px;vertical-align:middle;">';
        echo '</p>';
        unset($_SESSION['successMessage']); // Clear the message so it doesn't appear again on refresh
    }
}


function evaluateUserGuess($userGuess, $correctAnswer, $originalSequence)
{
    // Check if all elements are different
    if (count(array_diff($userGuess, $originalSequence)) == count($userGuess)) {
        return "all-different";
    }

    // Check if some elements are different
    foreach ($userGuess as $element) {
        if (!in_array($element, $originalSequence)) {
            return "some-different";
        }
    }

    // Check if the order is incorrect
    if ($userGuess !== $correctAnswer) {
        return "incorrect-order";
    }

    // Default to a general error if none of the above
    return "error";
}
