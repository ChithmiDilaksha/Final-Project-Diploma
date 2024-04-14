<?php
session_start();

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

// Fetch grade data
$sql_grades = "SELECT classID FROM grade";
$result_grades = $connection->query($sql_grades);

// Fetch student data
$sql_students = "SELECT SID FROM student";
$result_students = $connection->query($sql_students);

if (isset($_POST["add"])) 
{
    $SID = $_POST["SID"];
    $Term = $_POST["term"]; // Corrected the variable name
    $Sinhala = $_POST["marks"]["Sinhala"]; // Corrected the array access
    $Maths = $_POST["marks"]["Maths"]; // Corrected the array access
    $Science = $_POST["marks"]["Science"]; // Corrected the array access
    $History = $_POST["marks"]["History"]; // Corrected the array access
    $Buddhist = $_POST["marks"]["Buddhist"]; // Corrected the array access
    $English = $_POST["marks"]["English"]; // Corrected the array access
    $feedback = $_POST["feedback"];

    // Check if marks for the selected student and term already exist
    $check_marks_query = "SELECT * FROM marks WHERE SID = ? AND Term = ?";
    $stmt_check_marks = $connection->prepare($check_marks_query);
    $stmt_check_marks->bind_param("ss", $SID, $Term);
    $stmt_check_marks->execute();
    $result_marks = $stmt_check_marks->get_result();

    if ($result_marks->num_rows > 0) {
        echo '<p style="color: red;">Marks for this student and term already exist.</p>';
    } else {
        // Prepare and bind SQL statement
        $sql = "INSERT INTO marks (SID, Term, Sinhala, Maths, Science, History, Buddhist, English, feedback) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sssssssss", $SID, $Term, $Sinhala, $Maths, $Science, $History, $Buddhist, $English, $feedback);
        if ($stmt->execute()) {
            echo "Marks added successfully.";
            header("Location: viewMarks.php");
            exit(); // Stop further execution after redirection
        } else {
            echo '<script>alert("Invalid details. ");</script>';
        }

        // Close statement
        $stmt->close();
    }

    // Close statement for checking marks
    $stmt_check_marks->close();
}
if (isset($_POST["update"])) {
    // Update functionality
    $SID = $_POST["SID"];
    $Term = $_POST["term"]; // Corrected the variable name
    $Sinhala = $_POST["marks"]["Sinhala"]; // Corrected the array access
    $Maths = $_POST["marks"]["Maths"]; // Corrected the array access
    $Science = $_POST["marks"]["Science"]; // Corrected the array access
    $History = $_POST["marks"]["History"]; // Corrected the array access
    $Buddhist = $_POST["marks"]["Buddhist"]; // Corrected the array access
    $English = $_POST["marks"]["English"]; // Corrected the array access
    $feedback = $_POST["feedback"];

    // Update the existing record in the database
    $update_query = "UPDATE marks SET Sinhala=?, Maths=?, Science=?, History=?, Buddhist=?, English=?, feedback=? WHERE SID=? AND Term=?";
    $stmt = $connection->prepare($update_query);
    $stmt->bind_param("sssssssss", $Sinhala, $Maths, $Science, $History, $Buddhist, $English, $feedback, $SID, $Term);
    
    if ($stmt->execute()) {
        echo "Marks updated successfully.";
        header("Location: viewMarks.php");
        exit(); // Stop further execution after redirection
    } else {
        echo '<script>alert("Failed to update marks. ");</script>';
    }

    // Close statement
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Marks Add Form</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
    <h2>Student Marks Add Form</h2>
    <form method="post" action="#">
      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="year">Year:</label>
          <select id="year" name="year" class="form-control">
            <?php
            // Assuming 2020 to 2050
            for ($year = 2020; $year <= 2050; $year++) {
              echo "<option value=\"$year\">$year</option>";
            }
            ?>
          </select>
        </div>

        <div class="form-group col-md-4">
          <label for="classID">Grade:</label>
          <select class="form-control" id="classID" name="classID" required onchange="fetchStudents(this.value)">
            <?php
            if ($result_grades->num_rows > 0) {
                while ($row = $result_grades->fetch_assoc()) {
                    echo "<option value='" . $row["classID"] . "'>" . $row["classID"] . "</option>";
                }
            } else {
                echo "No classes found.";
            }
            ?>
          </select>
        </div>
       <div class="form-group col-md-4">
          <label for="SID">Student ID:</label>
          <select class="form-control" id="SID" name="SID" required>
           <?php
            if ($result_students->num_rows > 0) {
                while ($row = $result_students->fetch_assoc()) {
                    echo "<option value='" . $row["SID"] . "'>" . $row["SID"] . "</option>";
                }
            } else {
                echo "No students found.";
            }
            ?>
          </select>
        </div>
        <div class="form-group col-md-4">
          <label for="term">Term:</label>
          <select class="form-control" id="term" name="term" required>
            <option value="1">1st Term</option>
            <option value="2">2nd Term</option>
            <option value="3">3rd Term</option>
          </select>
        </div>
      </div>
      
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Subjects</th>
              <th>Marks</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Fetch subject names
            $subjects = array("Sinhala", "Maths", "Science", "History", "Buddhist", "English");
            foreach ($subjects as $subject) {
                echo "<tr>";
                echo "<td>$subject</td>";
                echo "<td><input type='number' name='marks[$subject]' class='form-control' min='0' max='100' required></td>";
                echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
      
      <div class="form-group">
        <label for="feedback">Feedback:</label>
        <textarea id="feedback" name="feedback" class="form-control" rows="3" required></textarea>
      </div>
      
      <button type="submit" name="add" id="add" class="btn btn-primary">Submit</button>
      <button type="button" class="btn btn-warning" onclick="clearForm()">Clear</button>
      <button type="submit" id="update" class="btn btn-info" name="update">Update</button>
      <a href="viewMarks.php" class="btn btn-success">View</a>
    </form>
  </div>

  <script>
  // Your JavaScript functions as before

</script>

</body>
</html>
