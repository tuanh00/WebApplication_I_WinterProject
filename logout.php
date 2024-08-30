<?php
session_start(); // Start the session

// Destroy the session and all its data
session_unset();
session_destroy();

// Redirect to the home page
header("Location: index.php");
exit();
