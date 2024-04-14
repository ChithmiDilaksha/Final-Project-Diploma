<?php
// Database connection
$servername = "localhost";
$username = "mydatabase";
$password = "mydatabase";
$dbname = "studentmarksdisplaysystem";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the number of rows in the grade table
$getRowCountQuery = "SELECT COUNT(*) as rowCount FROM grade";
$result = $conn->query($getRowCountQuery);
$row = $result->fetch_assoc();
$rowCount = $row["rowCount"];

// Calculate new GradeID
$nextGradeID = $rowCount + 1;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["add"])) {
        $classID = $_POST["classID"];

        // Insert the new class into the database
        $insertClassQuery = "INSERT INTO grade (GradeID, classID) VALUES ('$nextGradeID', '$classID')";
        if ($conn->query($insertClassQuery) === TRUE) {
            echo "New class added successfully!";
            // Increment the next available GradeID by 1 for the next entry
            $nextGradeID++;
        } else {
            echo "Error: " . $insertClassQuery . "<br>" . $conn->error;
        }
    }
    if (isset($_POST["clear"])) {
        // Clear form fields
        $classID = "";
    }
}

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Class Form</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="GradeID">GradeID</label>
                <input type="text" class="form-control" id="GradeID" name="GradeID" value="<?php echo $nextGradeID; ?>" readonly>
            </div>
            <!-- Display other columns here -->
            <div class="form-group">
                <label for="classID">Class Name</label>
                <input type="text" class="form-control" id="classID" name="classID" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add">Add</button>
            <button type="submit" class="btn btn-danger" name="clear">Clear</button>
            <a href="ViewClass.php" class="btn btn-info">View</a>
            <a href="AdminDashboard.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</body>
</html>
