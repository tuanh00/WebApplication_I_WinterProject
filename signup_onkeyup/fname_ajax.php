<?php
$fname = $_POST["value"]; // Should use POST since it's an AJAX post request
$warn_msg = "First name must start with a letter [a-z][A-Z]";
$no_warn_msg = "";


include_once '../includes/functions.inc.php';

if (emptyInput($fname)) {
    echo "First name cannot be empty."; // Redirect to signup page with error message
    exit(); // Stop the script from running
}

if (!startsWithLetter($fname)) {
    echo $warn_msg; // Redirect to signup page with error message
    exit(); // Stop the script from running
}
