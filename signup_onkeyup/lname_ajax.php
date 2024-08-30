<?php
$lname = $_POST["value"]; // Should use POST since it's an AJAX post request
$warn_msg = "Last name must start with a letter [a-z][A-Z]";
$no_warn_msg = "";


include_once '../includes/functions.inc.php';

if (emptyInput($lname)) {
    echo "Last name cannot be empty."; // Redirect to signup page with error message
    exit(); // Stop the script from running
}

if (!startsWithLetter($lname)) {
    echo $warn_msg; // Redirect to signup page with error message
    exit(); // Stop the script from running
}
