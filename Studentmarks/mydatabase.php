<?php 

$servername = "localhost";
$username = "root"; // Ensure this is your MySQL username, often it's "root" in development environments
$password = ""; // The password to connect to your MySQL, for development it might be an empty string ""
$database = "studentmarksdisplaysystem"; // Make sure there are no leading or trailing spaces
$connection = new mysqli($servername, $username, $password, $database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
} else {
  echo "Connection successful"; // It's usually not a good idea to echo anything here for a production environment
}

?>
