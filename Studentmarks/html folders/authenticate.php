<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "Chithmi2005@.";
$database = "projectfinal";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize user inputs
function sanitizeInput($input) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars($input));
}

// Function to authenticate user
function authenticateUser($username, $password) {
    global $conn;
    $username = sanitizeInput($username);
    $password = sanitizeInput($password);

    // Query to fetch user from database
    $sql = "SELECT * FROM Users WHERE UserName='$username' AND Passwords='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, authentication successful
        return true;
    } else {
        // User not found, authentication failed
        return false;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["Name"];
    $password = $_POST["password"];

    if (authenticateUser($username, $password)) {
        // Redirect user based on user type
        header("Location: index.html"); // Change next_page.php to the appropriate page
    } else {
        // Authentication failed, display error message or handle it accordingly
        echo "<script>alert('Invalid username or password.')</script>";
    }
}

// Close connection
$conn->close();
?>
