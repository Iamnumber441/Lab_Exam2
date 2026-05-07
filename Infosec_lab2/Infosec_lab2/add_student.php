<?php
session_start();
include("db.php");

/* ================= ACCESS CONTROL ================= */
/* FIX: matches login session (user_id, role, username) */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

/* Optional: restrict only admin (uncomment if needed) */
/*
if ($_SESSION['role'] !== 'admin') {
    die("Access denied");
}
*/

/* ================= INPUT VALIDATION FUNCTION ================= */
function cleanInput($data) {
    return trim(htmlspecialchars($data, ENT_QUOTES, 'UTF-8'));
}

/* ================= INSERT STUDENT ================= */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $student_id = cleanInput($_POST['student_id']);
    $fullname = cleanInput($_POST['fullname']);
    $email = cleanInput($_POST['email']);
    $course = cleanInput($_POST['course']);
    $course_description = cleanInput($_POST['course_description']);

    /* Validate required fields */
    if (empty($student_id) || empty($fullname) || empty($email) || empty($course)) {
        die("All required fields must be filled out.");
    }

    /* Validate email format */
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    /* ================= SECURE INSERT (PREPARED STATEMENT) ================= */
    $stmt = $conn->prepare(
        "INSERT INTO students (student_id, fullname, email, course, course_description)
         VALUES (?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "sssss",
        $student_id,
        $fullname,
        $email,
        $course,
        $course_description
    );

    $stmt->execute();

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Student</title>
</head>
<body>

<h2>Add Student</h2>

<!-- Optional display logged in user -->
<p>Logged in as: <?php echo $_SESSION['username']; ?></p>

<form method="POST">
    Student ID: <input type="text" name="student_id" required><br>
    Full Name: <input type="text" name="fullname" required><br>
    Email: <input type="email" name="email" required><br>
    Course: <input type="text" name="course" required><br>
    Course Description: <input type="text" name="course_description"><br>
    <button type="submit">Add</button>
</form>

</body>
</html>