
<!DOCTYPE html>
<html>

<head>
    <title>Answer</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1 class="blueText">Registration List</h1>
        <hr />
        <?php
        //Assign data collected from the form
           
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdrepeat = $_POST["pwdrepeat"];


        //Load the content of the user-defined functions used to interact with MySQL
        require_once "../includes/dbh.inc.php";
        require_once "../includes/functions.inc.php";
        // Create the user in the database
       createUser($conn, $fname, $lname, $username, $pwd);

        // Display success message
        echo "<p>User registration successful!</p>";


        ?>
        <div id="back">
            <a href="../index.php"><input type="submit" value="Try again!"></a>
        </div>
</body>

</html>