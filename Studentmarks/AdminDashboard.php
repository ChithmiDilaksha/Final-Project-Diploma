<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-size: 18px; /* Adjust font size */
        }
        h1 {
            font-size: 36px; /* Adjust title font size */
        }
        .box {
            width: 100%;
            height: 200px;
            margin: 20px;
            border-radius: 10px;
            padding: 20px;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer; /* Change cursor to pointer on hover */
        }
        .students {
            background-color: #007bff; /* Blue */
        }
        .teachers {
            background-color: #28a745; /* Green */
        }
        .admins {
            background-color: #dc3545; /* Red */
        }
        .subjects {
            background-color: #ffc107; /* Yellow */
        }
        .grades {
            background-color: #17a2b8; /* Teal */
        }
        .back-button {
            position: absolute;
            top: 50px;
            right: 380px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="btn btn-secondary back-button">Back</a>

        <h1 class="text-center mt-5">Welcome to Admin Dashboard</h1>

        <!-- Colored Boxes for Student, Teacher, Admin, Subjects, and Grades -->
        <div class="row">
            <div class="col-md-4">
                <div class="box students" onclick="redirectTo('StudentDetails.php')">
                    <h3>Students</h3>
                    <!-- Display student-related information or links -->
                </div>
            </div>
            <div class="col-md-4">
                <div class="box teachers" onclick="redirectTo('TeacherDetails.php')">
                    <h3>Teachers</h3>
                    <!-- Display teacher-related information or links -->
                </div>
            </div>
            <div class="col-md-4">
                <div class="box admins" onclick="redirectTo('AdminDetails.php')">
                    <h3>Admins</h3>
                    <!-- Display admin-related information or links -->
                </div>
            </div>
            <div class="col-md-4">
                <div class="box subjects" onclick="redirectTo('SubjectDetails.php')">
                    <h3>Subjects</h3>
                    <!-- Display Subjects-related information or links -->
                </div>
            </div>
            <div class="col-md-4">
                <div class="box grades" onclick="redirectTo('GradeDetails.php')">
                    <h3>Grade</h3>
                    <!-- Display Grade-related information or links -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function redirectTo(page) {
            window.location.href = page;
        }
    </script>
</body>
</html>
