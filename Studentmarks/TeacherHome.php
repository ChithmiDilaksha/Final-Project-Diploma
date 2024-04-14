<?php
session_start();

// Check if the user is logged in as a teacher
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Retrieve username from session
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-size: 18px; /* Adjust font size */
        }
        .container {
            text-align: center; /* Center align the content */
            margin-top: 50px; /* Add some top margin */
        }
        h1 
        {
            font-size: 36px; /* Adjust title font size */
        }
        .btn-lg {
            padding: 30px 50px; /* Adjust padding to make buttons larger */
            font-size: 30px; /* Adjust font size of buttons */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Teacher Dashboard</h1>
        <p>Hello, <?php echo $username; ?>!</p>
        <a href="addmarks.php" class="btn btn-success btn-lg">Add Marks</a>
       
        <a href="index.php" class="btn btn-primary btn-lg">Logout</a>
    </div>

</body>
</html>
