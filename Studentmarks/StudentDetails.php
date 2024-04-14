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
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Check if form fields are set
    if (isset($_POST["add"])) 
    {
        // Student details
        $SID = $_POST["SID"];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $Fullname = $_POST['Fullname'];
        $Email = $_POST['Email'];
        $phonenum = $_POST['phonenum'];
        $Class = $_POST['Class'];
        $Address = $_POST['Address'];

        // Check if username already exists
        $check_SID_query = "SELECT * FROM student WHERE SID = ?";
        $stmt_check_SID = $connection->prepare($check_SID_query);
        $stmt_check_SID->bind_param("s", $SID);
        $stmt_check_SID->execute();
        $result_SID = $stmt_check_SID->get_result();

        if ($result_SID->num_rows > 0) 
        {
            echo '<script>alert("Please enter another Student ID.");</script>';
        } 
        else 
        {
            $usertype = "Student";

            // Insert student details into student table
            $sql = "INSERT INTO student (SID, username, password, Fullname, Email, phonenum, Class, Address, usertype) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("sssssssss", $SID, $username, $password, $Fullname, $Email, $phonenum, $Class, $Address, $usertype);
            if ($stmt->execute()) 
            {
                echo '<script>alert("Student details added successfully.");</script>';
            } 
            else 
            {  
                echo '<script>alert("Details Add is not Success ,Add Correct Details");</script>';
                header("Location: StudentDetails.php");
            }

            // Close statement
            $stmt->close();

            // Insert student details into studentgrade table
            $sql_studentgrade = "INSERT INTO studentgrade (SID, GID) VALUES (?, ?)";
            $stmt_studentgrade = $connection->prepare($sql_studentgrade);
            $stmt_studentgrade->bind_param("ss", $SID, $Class);
            $stmt_studentgrade->execute();
            $stmt_studentgrade->close();
        }
    }

    if (isset($_POST["update"])) 
    {
        // Student details
        $SID = $_POST['SID']; 
        $username = $_POST['username'];
        $password = $_POST['password'];
        $Fullname = $_POST['Fullname'];
        $Email = $_POST['Email'];
        $phonenum = $_POST['phonenum'];
        $Class = $_POST['Class'];
        $Address = $_POST['Address'];

        $check_SID_query = "SELECT * FROM student WHERE SID = ?";
        $stmt_check_SID = $connection->prepare($check_SID_query);
        $stmt_check_SID->bind_param("s", $SID); 
        $stmt_check_SID->execute();
        $result_SID = $stmt_check_SID->get_result();

        if ($result_SID->num_rows == 1) 
        {
            $usertype = "Student"; 

            // Update student details in student table
            $sql = "UPDATE student SET username=?, password=?, Fullname=?, Email=?, phonenum=?, Class=?, Address=?, usertype=? WHERE SID=?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("sssssssss", $username, $password, $Fullname, $Email, $phonenum, $Class, $Address, $usertype, $SID);
        
            if ($stmt->execute()) 
            {
                echo "Student details updated successfully.";
            } 
            else 
            {
                echo '<script>alert("Invalid update. Add Correct Student ID");</script>';
                header("Location: StudentDetails.php");
            }

            // Close statement
            $stmt->close();

            // Update student details in studentgrade table
            $sql_studentgrade = "UPDATE studentgrade SET GID=? WHERE SID=?";
            $stmt_studentgrade = $connection->prepare($sql_studentgrade);
            $stmt_studentgrade->bind_param("ss", $Class, $SID);
            $stmt_studentgrade->execute();
            $stmt_studentgrade->close();
        } 

        // Close statement for checking SID existence
        $stmt_check_SID->close();
    }

    // Handle delete operation
    if (isset($_POST["Delete"])) 
    {
        // Student details
        $SID = $_POST["SID"]; 
        $password = $_POST["password"];

        // Delete student details from student table
        $sql = "DELETE FROM student WHERE SID = ? AND password = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("is", $SID, $password); 

        if ($stmt->execute()) 
        {
            echo "Student details deleted successfully.";
        } 
        else 
        {
            echo '<script>alert("If you cannot delete ,Click view And Delete");</script>';
            header("Location: StudentDetails.php");
        }

        // Close statement
        $stmt->close();

        // Delete student details from studentgrade table
        $sql_studentgrade = "DELETE FROM studentgrade WHERE SID = ?";
        $stmt_studentgrade = $connection->prepare($sql_studentgrade);
        $stmt_studentgrade->bind_param("s", $SID);
        $stmt_studentgrade->execute();
        $stmt_studentgrade->close();
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
    <title>Add Student Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Add Student Details</h1>
        <form action="StudentDetails.php" method="POST">
            <div class="form-group">
                <label for="SID">Student ID:</label>
                <input type="text" class="form-control" id="SID" name="SID" required>
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
                <label for="Fullname">Full Name:</label>
                <input type="text" class="form-control" id="Fullname" name="Fullname" required>
            </div>
            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="email" class="form-control" id="Email" name="Email" required>
            </div>
            <div class="form-group">
                <label for="phonenum">Phone Number:</label>
                <input type="tel" class="form-control" id="phonenum" name="phonenum" required>
            </div>
            <div class="form-group">
                <label for="Class">Grade:</label>
                <select class="form-control" id="Class" name="Class" required>
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
                    }

                    // Fetch grade 
                    $sql = "SELECT classID FROM grade";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["classID"] . "'>" . $row["classID"] . "</option>";
                        }
                    } else {
                        echo "No classes found.";
                    }

                    // Close connection
                    $conn->close();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="Address">Address:</label>
                <textarea class="form-control" id="Address" name="Address" rows="4" required></textarea>
            </div>
            <button type="submit" name="add" class="btn btn-primary">Add Student</button>
            <button type="submit" name="update" class="btn btn-success">Update Student</button>
            <button type="submit" name="Delete" class="btn btn-danger">Delete Student</button>
            <button type="button" onclick="clearForm()" class="btn btn-secondary">Clear</button>
            <a href="ViewStudents.php" class="btn btn-primary">View Students</a>
            <a href="AdminDashboard.php" class="btn btn-secondary">Back</a>
        </form>

        <script>
            function clearForm() {
                document.getElementById("SID").value = "";
                document.getElementById("username").value = "";
                document.getElementById("password").value = "";
                document.getElementById("Fullname").value = "";
                document.getElementById("Email").value = "";
                document.getElementById("phonenum").value = "";
                document.getElementById("Class").value = "";
                document.getElementById("Address").value = "";
            }
        </script>
    </div>
</body>
</html>
