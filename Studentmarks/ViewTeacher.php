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
    $TID = $_POST['TID'];

    // SQL to delete record
    $deleteQuery = "DELETE FROM teacher WHERE TID = '$TID'";
    
    if ($connection->query($deleteQuery) === TRUE) {
        echo "Record deleted successfully";
        
    } else {
        echo "Error deleting record: " . $connection->error;
    }
}

// Query to fetch all rows from the admin table
$query = "SELECT * FROM teacher";
$result = $connection->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Teachers</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Teacher Details</h1>
         <div class="mb-3">
            <button class="btn btn-primary" onclick="location.reload()">Refresh</button>
            <a href="TeacherDetails.php" class="btn btn-secondary">Back</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>User Type</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Class</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display data in table rows
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['TID'] . "</td>";
                        echo "<td>" . $row['FullName'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['Password'] . "</td>";
                        echo "<td>" . $row['usertype'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['phonenumber'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['GID'] . "</td>";
                         echo "<td>";
                        echo "<form method='post' action=''>";
                        echo "<input type='hidden' name='TID' value='" . $row['TID'] . "'>";
                        echo "<button type='submit' name='delete' class='btn btn-danger'>Delete</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No Teachers found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>