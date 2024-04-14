<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "studentmarksdisplaysystem";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Delete record if delete button is clicked
if (isset($_POST['delete'])) {
    $SID = $_POST['SID'];
    $Term = $_POST['Term'];

    // SQL to delete record for the selected student ID
    $deleteQuery = "DELETE FROM marks WHERE SID = '$SID' AND Term ='$Term'";
    
    if ($connection->query($deleteQuery) === TRUE) {
        echo "Record for student ID $SID  , and term $Term deleted successfully";
        
    } else {
        echo "Error deleting record: " . $connection->error;
    }
}

// Query to fetch all rows from the marks table
$query = "SELECT * FROM marks";
$result = $connection->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Marks</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Marks Details</h1>
        <div class="mb-3">
            <button class="btn btn-primary" onclick="location.reload()">Refresh</button>
            <a href="addmarks.php" class="btn btn-secondary">Back</a>
        </div>
        <table class="table">
            <thead>
                <th>Student ID</th>
                <th>Term</th>
                <th>Sinhala</th>
                <th>Maths</th>
                <th>Science</th>
                <th>History</th>
                <th>Buddhist</th>
                <th>English</th>
                <th>Feedback</th>
            </thead>
            <tbody>
                <?php
                // Display data in table rows
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . (isset($row['SID']) ? $row['SID'] : '') . "</td>";
                        echo "<td>" . (isset($row['Term']) ? $row['Term'] : '') . "</td>";
                        echo "<td>" . (isset($row['Sinhala']) ? $row['Sinhala'] : '') . "</td>";
                        echo "<td>" . (isset($row['Maths']) ? $row['Maths'] : '') . "</td>";
                        echo "<td>" . (isset($row['Science']) ? $row['Science'] : '') . "</td>";
                        echo "<td>" . (isset($row['History']) ? $row['History'] : '') . "</td>";
                        echo "<td>" . (isset($row['Buddhist']) ? $row['Buddhist'] : '') . "</td>";
                        echo "<td>" . (isset($row['English']) ? $row['English'] : '') . "</td>";
                        echo "<td>" . (isset($row['feedback']) ? $row['feedback'] : '') . "</td>";
                        echo "<td>";
                        echo "<form method='post' action=''>";
                        echo "<input type='hidden' name='SID' value='" . $row['SID'] . "'>";
                         echo "<input type='hidden' name='Term' value='" . $row['Term'] . "'>";
                        echo "<button type='submit' name='delete' class='btn btn-danger'>Delete</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No marks found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
