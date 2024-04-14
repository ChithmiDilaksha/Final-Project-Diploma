<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "studentmarksdisplaysystem";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") 
{
    // Create connection
    $connection = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($connection->connect_error) 
    {
        die("Connection failed: " . $connection->connect_error);
    }
    // Handle form submission
    if (isset($_POST["add"])) 
    {
        $AdminID = $_POST["AdminID"];
        $FullName = $_POST["FullName"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $phonenumber = $_POST["phonenumber"];
        $Address = $_POST["Address"];
        $email = $_POST["email"];

        // Check if username already exists
        $check_username_query = "SELECT * FROM admin WHERE AdminID = ?";
        $stmt_check_AdminID = $connection->prepare($check_username_query);
        $stmt_check_AdminID->bind_param("s", $AdminID);
        $stmt_check_AdminID->execute();
        $result_AdminID = $stmt_check_AdminID->get_result();

        if ($result_AdminID ->num_rows > 0) 
        {
            echo '<p style="color: red;">Please enter another username.</p>';
        } 
        else 
        {
            // Prepare and bind SQL statement
            $sql = "INSERT INTO admin (AdminID,FullName,username, password, usertype, phonenumber, Address, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("ssssssss",$AdminID, $FullName, $username, $password, $usertype, $phonenumber, $Address, $email);

            // Set parameters and execute statement
            $usertype = "Admin"; // Assuming the user type is 'Admin'
            if ($stmt->execute()) 
            {
              echo "Admin details added successfully.";
              header("Location: ViewAdmins.php");

            } else 
            {
                 echo '<script>alert("Invalid details. ");</script>';
            }

            // Close statement
            $stmt->close();
        }

        // Close statement for checking username
        $stmt_check_AdminID->close();
    }
    
    if (isset($_POST["update"])) 
    {
        $AdminID = $_POST["AdminID"];
        $FullName = $_POST["FullName"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $phonenumber = $_POST["phonenumber"];
        $Address = $_POST["Address"];
        $email = $_POST["email"];

        // Check if username and AdminID are correct
        $check_credentials_query = "SELECT * FROM admin WHERE AdminID = ? AND username = ?";
        $stmt_check_credentials = $connection->prepare($check_credentials_query);
        $stmt_check_credentials->bind_param("ss", $username, $AdminID);
        $stmt_check_credentials->execute();
        $result_credentials = $stmt_check_credentials->get_result();

        if ($result_credentials->num_rows == 1) {
            // At least one of the other fields is filled
            if (!empty($AdminID) || !empty($email) || !empty($phonenumber) || !empty($address)) {
                // Prepare SQL statement for updating existing admin
                $sql = "UPDATE admin SET username=?,password=?, FullName=?, email=?, phonenumber=?, Address=? WHERE AdminID=?";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param("sssssss",$username, $password, $FullName, $email, $phonenumber, $Address, $AdminID);

                // Execute statement for updating existing admin
                if ($stmt->execute()) 
                {
                    echo "Admin details updated successfully.";
                } 
                else 
                {
                    echo "Error updating admin details: " . $stmt->error;
                }

                // Close statement
                $stmt->close();
            } else {
                echo "At least one field (other than username and AdminID) should be filled to update.";
            }
        } else {
            echo "Incorrect username or AdminID.";
        }

        // Close statement for checking credentials
        $stmt_check_credentials->close();
    }


    // Handle delete operation
    if (isset($_POST["Delete"])) 
    {
        $username = $_POST["username"];
        $AdminID = $_POST["AdminID"];

        // Prepare SQL statement for deleting admin data
        $sql = "DELETE FROM admin WHERE username = ? AND AdminID = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ss", $username, $AdminID);

        // Execute the delete statement
        if ($stmt->execute()) 
        {
            echo "Admin details deleted successfully.";
        } 
        else 
        {
            echo "Error deleting admin details: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-size: 18px; /* Adjust font size */
        }
        .container {
            margin-top: 50px; /* Add some top margin */
        }
        h1 {
            font-size: 36px; /* Adjust title font size */
            text-align: center; /* Center align the title */
        }
        .form-control {
            margin-bottom: 20px; /* Add spacing between form controls */
        }
        .btn {
            margin-right: 10px; /* Add spacing between buttons */
        }
        #adminTable {
            display: none; /* Hide the table by default */
        }
        .view-button {
            background-color: #6f42c1; /* Purple color for the view button */
            border-color: #6f42c1; /* Purple color for the border */
            color: #fff; /* White text color */
        }
        .view-button:hover {
            background-color: #5a3ac5; /* Darker purple color on hover */
            border-color: #5a3ac5; /* Darker purple color for the border on hover */
        }
        .welcome-message {
            display: block; /* Show the welcome message by default */
        }
        .hide-welcome {
            display: none; /* Hide the welcome message when view button is clicked */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="welcome-message">Welcome to Admin Dashboard</h1>

        <!-- Add Admin Details Form -->
        <form id="adminForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="AdminID">AdminID:</label>
                <input type="text" class="form-control" name="AdminID" id="AdminID" method="POST" required>
            </div>
            <div class="form-group">
                <label for="FullName">Full Name:</label>
                <input type="text" class="form-control" name="FullName" id="FullName" method="POST" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" id="username" method="POST" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" method="POST" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" id="email"  method="POST" required>
            </div>
            <div class="form-group">
                <label for="phonenumber">Phone Number:</label>
                <input type="tel" class="form-control" name="phonenumber" id="phonenumber" method="POST" required>
            </div>
            <div class="form-group">
                <label for="Address">Address:</label>
                <textarea class="form-control" name="Address" id="Address" method="POST" required></textarea>
            </div>
            <button type="submit" name="add" class="btn btn-primary">Add Details</button>
            <button type="button"  class="btn btn-secondary" onclick="clearForm();">Clear Details</button>
            <button type="submit" name="Delete" id="Delete" class="btn btn-danger" >Delete Details</button>
            <button type="submit" name ="update"class="btn btn-success" >Update Details</button>
            <a href="ViewAdmins.php" class="btn btn-primary">View Admins</a>
            <a href="AdminDashboard.php" class="btn btn-secondary">Back</a>

        </form>

        <!-- Admin Details Table -->
        <table id="adminTable" class="table">
            <thead>
                <tr>
                    <th>AdminID</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <!-- Display admin details here -->
            </tbody>
        </table>
    </div>

    <script>
    function clearForm() 
    {
        document.getElementById("AdminID").value = "";
        document.getElementById("FullName").value = "";
        document.getElementById("password").value = "";
        document.getElementById("email").value = "";
        document.getElementById("phonenumber").value = "";
        document.getElementById("Address").value = "";
        document.getElementById("username").value = "";

    }

    </script>
</body>
</html>
        