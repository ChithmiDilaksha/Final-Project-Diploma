<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "studentmarksdisplaysystem"; // Update with your database name

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if form is submitted
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Check if form fields are set
    if (isset($_POST["add"])) 
    {
        $TID = $_POST["TID"];
        $FullName = $_POST['FullName'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $phonenumber = $_POST['phonenumber'];
        $address = $_POST['address'];
        $classID = $_POST['classID'];

        // Check if username already exists
        $check_TID_query = "SELECT * FROM teacher WHERE TID = ?";
        $stmt_check_TID = $connection->prepare($check_TID_query);
        $stmt_check_TID->bind_param("s", $TID);
        $stmt_check_TID->execute();
        $result_TID = $stmt_check_TID->get_result();

        if ($result_TID->num_rows > 0) 
        {
            echo '<script>alert("Please enter another Teacher ID.");</script>';
        } 
        else 
        {
            // Define $usertype
            $usertype = "Teacher";

            $sql = "INSERT INTO teacher (TID,FullName, username, Password, usertype, email, phonenumber, address,GID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("sssssssss", $TID, $FullName, $username, $password, $usertype, $email, $phonenumber, $address, $classID);
            if ($stmt->execute()) 
            {
                echo '<script>alert("Teacher details added successfully.");</script>';

                // Update the grade table with teacher's details
                $sql_grade = "UPDATE grade SET TID=?, FullName=? WHERE classID=?";
                $stmt_grade = $connection->prepare($sql_grade);
                $stmt_grade->bind_param("sss", $TID, $FullName, $classID);
                $stmt_grade->execute();
                $stmt_grade->close();
            } 
            else 
            {  
                echo '<script>alert("Details Add is not Success ,Add Correct Details");</script>';
                header("Location: TeacherDetails.php");
            }

            // Close statement
            $stmt->close();
        }
    }

    // Handle updating teacher details
    if (isset($_POST["update"])) 
    {
        $TID = $_POST['TID']; // Add TID field
        $FullName = $_POST['FullName'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $phonenumber = $_POST['phonenumber'];
        $address = $_POST['address'];
        $classID = $_POST['classID'];

        // Check if teacher with provided TID exists
        $check_TID_query = "SELECT * FROM teacher WHERE TID = ?";
        $stmt_check_TID = $connection->prepare($check_TID_query);
        $stmt_check_TID->bind_param("s", $TID); // Assuming TID is an integer
        $stmt_check_TID->execute();
        $result_TID = $stmt_check_TID->get_result();

        if ($result_TID->num_rows == 1) 
        {
            $usertype = "Teacher"; // Initialize usertype
            // Prepare SQL statement for updating existing teacher
            $sql = "UPDATE teacher SET FullName=?, username=?, Password=?, usertype=?, email=?, phonenumber=?, address=?, GID=? WHERE TID=?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("sssssssss", $FullName, $username, $password, $usertype, $email, $phonenumber, $address, $classID, $TID);
        
            // Execute statement for updating existing teacher
            if ($stmt->execute()) 
            {
                echo "Teacher details updated successfully.";

                // Update the grade table with updated teacher's details
                $sql_grade = "UPDATE grade SET TID=?, FullName=? WHERE classID=?";
                $stmt_grade = $connection->prepare($sql_grade);
                $stmt_grade->bind_param("sss", $TID, $FullName, $classID);
                $stmt_grade->execute();
                $stmt_grade->close();
            } 
            else 
            {
                echo '<script>alert("Invalid update. Add Correct Teacher ID");</script>';
                header("Location: TeacherDetails.php");
            }

            // Close statement
            $stmt->close();
        } 

        // Close statement for checking TID existence
        $stmt_check_TID->close();
    }

    // Handle deleting teacher details
    if (isset($_POST["Delete"])) 
    {
        $TID = $_POST["TID"]; // Add TID field
        $password = $_POST["password"];

        // Prepare SQL statement for deleting teacher data
        $sql = "DELETE FROM teacher WHERE TID = ? AND Password = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("is", $TID, $password); // Assuming TID is an integer

        // Execute the delete statement
        if ($stmt->execute()) 
        {
            echo "Teacher details deleted successfully.";

            // Remove associated data from the grade table
            $sql_grade = "UPDATE grade SET TID=NULL, FullName=NULL WHERE TID=?";
            $stmt_grade = $connection->prepare($sql_grade);
            $stmt_grade->bind_param("s", $TID);
            $stmt_grade->execute();
            $stmt_grade->close();
        } 
        else 
        {
            echo '<script>alert("If you cannot delete ,Click view And Delete");</script>';
            header("Location: TeacherDetails.php");
        }

        // Close statement
        $stmt->close();
    }
    
} 

// Close MySQL connection
$connection->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Teacher Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Add Teacher Details</h1>
        <form action="TeacherDetails.php" method="POST">
            <div class="form-group">
                <label for="TID">Teacher ID:</label>
                <input type="text" class="form-control" id="TID" name="TID" required>
            </div>
            <div class="form-group">
                <label for="FullName">Full Name:</label>
                <input type="text" class="form-control" id="FullName" name="FullName" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="classID">Grade:</label>
                <select class="form-control" id="classID" name="classID" required>
                    <?php
                    // Database connection
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $database = "studentmarksdisplaysystem";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $database);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                        echo '<script>alert("Connection failed");</script>';
            header("Location: TeacherDetails.php");
                    }

                    // Fetch grade 
                    $sql = "SELECT classID FROM grade";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["classID"] . "'>" . $row["classID"] . "</option>";
                        }
                    } 
                    else {
                        echo "No classes found.";
                        echo '<script>alert("If you cannot Fonud ");</script>';
            header("Location: TeacherDetails.php");
                    }

                    // Close connection
                    $conn->close();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phonenumber">Phone Number:</label>
                <input type="tel" class="form-control" id="phonenumber" name="phonenumber" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea class="form-control" id="address" name="address" rows="4" required></textarea>
            </div>
            <button type="submit" name="add" class="btn btn-primary">Add Teacher</button>
            <button type="submit" name="update" class="btn btn-success">Update Teacher</button>
            <button type="submit" name="Delete" class="btn btn-danger">Delete Teacher</button>
            <button type="button" onclick="clearForm()" class="btn btn-secondary">Clear</button>
            <a href="ViewTeacher.php" class="btn btn-primary">View Admins</a>
            <a href="AdminDashboard.php" class="btn btn-secondary">Back</a>
        </form>

        <script>
            function clearForm() {
                document.getElementById("TID").value = "";
                document.getElementById("FullName").value = "";
                document.getElementById("password").value = "";
                document.getElementById("username").value = "";
                document.getElementById("Grade").value = "";
                document.getElementById("email").value = "";
                document.getElementById("phonenumber").value = "";
                document.getElementById("address").value = "";
            }
        </script>
    </div>
</body>
</html>
