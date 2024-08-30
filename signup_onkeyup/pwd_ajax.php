<?php

require_once '../includes/dbh.inc.php';
include_once '../includes/functions.inc.php';

$pwd = $_POST["pwd"] ?? '';
$pwdrepeat = $_POST["pwdrepeat"] ?? '';

$response = [
    'pwd' => '',
    'pwdrepeat' => ''
];

// Validate Password
if (empty($pwd)) {
    $response['pwd'] = "Password must be filled out.";
} elseif (!isMinLength($pwd)) {
    $response['pwd'] = "Password must be at least 8 characters long.";
}

// Validate Password Repeat only if Password is also provided
if (isset($_POST["pwd"]) && empty($pwdrepeat)) {
    $response['pwdrepeat'] = "Remember repeat password must be filled out.";
} elseif (isset($_POST["pwd"]) && !isMinLength($pwdrepeat)) {
    $response['pwdrepeat'] = "Repeat passwords must be at least 8 characters long.";
} elseif (isset($_POST["pwd"]) && !pwdMatch($pwd, $pwdrepeat)) {
    $response['pwdrepeat'] = "Both passwords do not match.";
}

// Encode and return the response as a JSON object
echo json_encode($response);
