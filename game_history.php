<?php
include_once 'header.php'; // This has the session_start() and checks for user authentication
include_once 'includes/dbh.inc.php'; // This containx the database connection
include_once 'includes/functions.inc.php'; 

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // User is not logged in, redirect to login page
    header('Location: login.php');
    exit();
}

// Fetch game history from the database
$sql = "SELECT * FROM history ORDER BY scoreTime DESC"; // Modify the query if needed
$stmt = mysqli_stmt_init($conn);
$historyData = [];

if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $historyData[] = $row;
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Error fetching game history.";
}

// Include HTML to display game history
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game History</title>
    <link rel="stylesheet" href="css/main.css" type="text/css"> <!-- Adjust the path as needed -->
</head>
<body>

<!-- Game History Table -->
<h2>Game History</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Outcome of the Game</th>
            <th>Number of Lives Used</th>
            <th>Date and Time</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($historyData as $game): ?>
        <tr>
            <td><?php echo htmlspecialchars($game['id']); ?></td>
            <td><?php echo htmlspecialchars($game['fName']); ?></td>
            <td><?php echo htmlspecialchars($game['lName']); ?></td>
            <td><?php echo htmlspecialchars($game['result']); ?></td>
            <td><?php echo htmlspecialchars($game['livesUsed']); ?></td>
            <td><?php echo htmlspecialchars($game['scoreTime']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>
</body>
</html>
