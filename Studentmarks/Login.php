<?php
session_start();

// Database connection details
$servername = "localhost";  // Change this to your MySQL server hostname
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$database = "studentmarksdisplaysystem"; // Change this to your MySQL database name

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Retrieve form data
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']); 
    $usertype = mysqli_real_escape_string($connection, $_POST['usertype']);
    // Determine the table based on usertype
    $table = '';
    switch ($usertype) {
        case 'Admin':
            $table = 'admin';
            break;
        case 'Teacher':
            $table = 'teacher';
            break;
        case 'Student':
            $table = 'student';
            break;
        default:
            echo '<script>alert("Invalid user type.");</script>';

            exit(); // Exit if usertype is invalid
    }
    

    // Query to check user credentials
    $query = "SELECT * FROM `$table` WHERE username='$username' AND password='$password'";
    $result = mysqli_query($connection, $query);

    // Check if the query returned any rows
    if (mysqli_num_rows($result) == 1) {
        // Set session variable for user authentication
        $_SESSION['username'] = $username;

        // Redirect users based on their user type
        switch ($usertype) {
            case 'Admin':
                header("Location: AdminDashboard.php");
                exit();
            case 'Teacher':
                header("Location: TeacherHome.php");
                exit();
            case 'Student':
                header("Location: StudentHome.php");
                exit();
        }
    } else {
        // Display error message if login fails
        echo '<script>alert("Invalid username or password.");</script>';

    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('assets/images/c.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            max-width: 400px;
            padding: 20px;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.7);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="form-container">
                    <h2 class="text-center">Welcome Back</h2>
                    <form name="loginForm" onsubmit="return validateForm()" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="form-group">
                            <label>Enter Your Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
                        </div>
                        <div class="form-group">
                            <label>Enter Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
                        </div>
                        <div class="form-group">
                            <label>Select User Type</label>
                            <select id="usertype" name="usertype" class="form-control" required>
                                <option value="">Select user type</option>
                                <option value="Teacher">Teacher</option>
                                <option value="Student">Student</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                        <div id="error-message" style="display: none; color: red; text-align: center;">Username, password, and user type must be filled out</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
