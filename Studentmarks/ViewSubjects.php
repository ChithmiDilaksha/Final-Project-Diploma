<?php
// Database connection details
$servername = "localhost";
$username = "mydatabase";
$password = "mydatabase";
$dbname = "studentmarksdisplaysystem";

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Delete record if delete button is clicked
if (isset($_POST['delete'])) {
    $subID = $_POST['subID'];

    // SQL to check if subject exists
    $checkQuery = "SELECT * FROM subject WHERE subID = '$subID'";
    $checkResult = $connection->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Subject exists, get the subject name
        $row = $checkResult->fetch_assoc();
        $subname = $row['subname'];

        // Check if the subject's column exists in the marks table
        $checkColumnQuery = "SHOW COLUMNS FROM marks LIKE '$subname'";
        $checkColumnResult = $connection->query($checkColumnQuery);

        if ($checkColumnResult->num_rows > 0) {
            // Column exists in marks table, delete it first
            $alterTableQuery = "ALTER TABLE marks DROP COLUMN `$subname`";
            if ($connection->query($alterTableQuery) === TRUE) {
                echo "Corresponding column '$subname' in marks table deleted.<br>";
            } else {
                echo "Error deleting column in marks table: " . $connection->error . "<br>";
            }
        } else {
            echo "Column '$subname' not found in the marks table.<br>";
        }

        // Proceed with deletion from subject table
        $deleteQuery = "DELETE FROM subject WHERE subID = '$subID'";
        if ($connection->query($deleteQuery) === TRUE) {
            echo "Record deleted successfully from subject table.";
        } else {
            echo "Error deleting record from subject table: " . $connection->error;
        }
    } else {
        echo "Subject delete success.";
    }
}

// Query to fetch all rows from the subject table
$query = "SELECT * FROM subject";
$result = $connection->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Subjects</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Subject Details</h1>
        <div class="mb-3">
            <button class="btn btn-primary" onclick="location.reload()">Refresh</button>
            <a href="SubjectDetails.php" class="btn btn-secondary">Back</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Subject ID</th>
                    <th>Subject Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display data in table rows
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['subID'] . "</td>";
                        echo "<td>" . $row['subname'] . "</td>";
                        echo "<td>";
                        echo "<form method='post' action=''>";
                        echo "<input type='hidden' name='subID' value='" . $row['subID'] . "'>";
                        echo "<button type='submit' name='delete' class='btn btn-danger'>Delete</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No subjects found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
