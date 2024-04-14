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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["add"])) {
        $subjectName = $_POST["subjectName"];

        // Get the last subID from the subject table
        $getLastSubIDQuery = "SELECT MAX(subID) as last_subID FROM subject";
        $result = $conn->query($getLastSubIDQuery);
        $row = $result->fetch_assoc();
        $lastSubID = $row["last_subID"];

        // Calculate new subID
        $newSubID = $lastSubID + 1;

        // Insert the new subject into the database
        $insertSubjectQuery = "INSERT INTO subject (subID, subname) VALUES ('$newSubID', '$subjectName')";
        if ($conn->query($insertSubjectQuery) === TRUE) {
            // Add a column to the marks table for the new subject
            $addColumnQuery = "ALTER TABLE marks ADD COLUMN $subjectName INT DEFAULT 0";
            if ($conn->query($addColumnQuery) === TRUE) {
                echo "New subject added successfully!";
            } else {
                echo "Error adding new subject column: " . $conn->error;
            }
            // Redirect back to the subject form
            header("Location: SubjectDetails.php");
            exit;
        } else {
            echo "Error: " . $insertSubjectQuery . "<br>" . $conn->error;
        }
    }
  if (isset($_POST["clear"])) {
        // Clear form fields
        $subjectName = "";
    }
}

// Get the next available subID
$getLastSubIDQuery = "SELECT MAX(subID) as last_subID FROM subject";
$result = $conn->query($getLastSubIDQuery);
$row = $result->fetch_assoc();
$nextSubID = $row["last_subID"] + 1;

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Subject Form</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="subjectNumber">Subject Number</label>
                <input type="text" class="form-control" id="subjectNumber" name="subjectNumber" value="<?php echo $nextSubID; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="subjectName">Subject Name</label>
                <input type="text" class="form-control" id="subjectName" name="subjectName" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add">Add</button>
            <button type="submit" class="btn btn-danger" name="clear">Clear</button>
            <a href="ViewSubjects.php" class="btn btn-info">View</a>
            <a href="AdminDashboard.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</body>
</html>
