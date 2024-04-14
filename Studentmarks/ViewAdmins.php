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
    $adminID = $_POST['adminID'];

    // SQL to delete record
    $deleteQuery = "DELETE FROM admin WHERE AdminID = '$adminID'";
    
    if ($connection->query($deleteQuery) === TRUE) {
        echo "Record deleted successfully";
        
    } else {
        echo "Error deleting record: " . $connection->error;
    }
}

// Query to fetch all rows from the admin table
$query = "SELECT * FROM admin";
$result = $connection->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Admins</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Admin Details</h1>
         <div class="mb-3">
            <button class="btn btn-primary" onclick="location.reload()">Refresh</button>
            <a href="AdminDetails.php" class="btn btn-secondary">Back</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>AdminID</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Usertype</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display data in table rows
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['AdminID'] . "</td>";
                        echo "<td>" . $row['FullName'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['password'] . "</td>";
                        echo "<td>" . $row['usertype'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['phonenumber'] . "</td>";
                        echo "<td>" . $row['Address'] . "</td>";
                        echo "<td>";
                        echo "<form method='post' action=''>";
                        echo "<input type='hidden' name='adminID' value='" . $row['AdminID'] . "'>";
                        echo "<button type='submit' name='delete' class='btn btn-danger'>Delete</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No admins found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
