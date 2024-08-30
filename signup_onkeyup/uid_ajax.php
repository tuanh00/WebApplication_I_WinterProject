<?php
require_once '../includes/dbh.inc.php'; // connectToDB function
$conn = connectToDB(); // call the function and store the connection 

$uid = $_POST["value"]; // Should use POST since it's an AJAX post request
$warn_msg = "Username must start with a letter [a-z][A-Z]";
$no_warn_msg = "";

include_once '../includes/functions.inc.php';

if (emptyInput($uid)) {
    echo "Username cannot be empty."; // Redirect to signup page with error message
    exit(); // Stop the script from running
}

if (!startsWithLetter($uid)) {
    echo $warn_msg; // Redirect to signup page with error message
    exit(); // Stop the script from running
}

if(!isMinLength($uid)) {
    echo "Username must be at least 8 characters long"; 
    exit(); 
}

 //connect the database to check if the username already exists
 if(isUsernameUnique($conn, $uid) !== false) {
    echo "Username is already taken. Please choose another one.";
    exit(); 
}
