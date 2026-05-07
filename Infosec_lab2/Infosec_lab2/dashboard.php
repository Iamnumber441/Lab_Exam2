<?php
session_start();
include("db.php");

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- OUTPUT SANITIZATION APPLIED -->
<h2>Welcome <?php echo htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8'); ?></h2>

<a href="add_student.php">Add Student</a> |
<a href="logout.php">Logout</a>

<h3>Student List</h3>

<table border="1">
<tr>
    <th>ID</th>
    <th>Student ID</th>
    <th>Full Name</th>
    <th>Email</th>
    <th>Course</th>
    <th>Action</th>
</tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM students");

while ($row = mysqli_fetch_assoc($result)) {
?>
<tr>
    <!-- OUTPUT SANITIZATION -->
    <td><?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($row['student_id'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($row['fullname'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($row['course'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td>
        <a href="delete_student.php?id=<?php echo urlencode($row['id']); ?>">
            Delete
        </a>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>