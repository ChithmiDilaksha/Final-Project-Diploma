<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Assuming you have a database connection established
// Replace these variables with your actual database credentials
$servername = "localhost";
$username_db = "mydatabase";
$password_db = "mydatabase";
$database = "studentmarksdisplaysystem";

// Initialize variables
$marks_display = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get SID from the form
    $input_SID = $_POST['SID'];

    // Create connection
    $conn = new mysqli($servername, $username_db, $password_db, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch marks associated with the SID
    $sql_marks = "SELECT * FROM marks WHERE SID = '$input_SID'";
    $result_marks = $conn->query($sql_marks);

    if ($result_marks->num_rows > 0) {
        // Display marks
        $marks_display .= "<div class='container'>";
        $marks_display .= "<h1>Welcome to Marks System, Student with SID $input_SID!</h1>";
        $marks_display .= "<p>Your marks:</p>";
        $marks_display .= "<ul>";
        while ($row_marks = $result_marks->fetch_assoc()) {
            // Check if 'subject' and 'marks' keys exist
            if (isset($row_marks["subject"]) && isset($row_marks["marks"])) {
                $marks_display .= "<li>Subject: " . $row_marks["subject"] . ", Marks: " . $row_marks["marks"] . "</li>";
            } else {
                $marks_display .= "<li>No marks available for this subject.</li>";
            }
        }
        $marks_display .= "</ul>";
        $marks_display .= "<a href='index.php' class='btn btn-danger logout-btn'>Logout</a>";
        $marks_display .= "</div>";
    } else {
        $marks_display .= "No marks found for Student with SID $input_SID.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Portal</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
        }

        .container {
            max-width: 800px; /* Increased max-width */
            margin: 100px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        p {
            font-size: 18px;
            color: #666;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <?php echo $marks_display; ?>
    <h2>Enter Your Student ID  View Marks:</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <input type="text" class="form-control" name="SID" placeholder="Enter Student ID (SID)" required>
        </div>
        <button type="submit" class="btn btn-primary">View Marks</button>
    </form>
</div>

<!-- Add Bootstrap JS (Optional) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
