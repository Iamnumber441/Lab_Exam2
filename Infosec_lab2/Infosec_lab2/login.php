<?php
session_start();
session_regenerate_id(true);
include("db.php");

if(isset($_POST['login'])){

    $username = $_POST['username'];
    // During registration / adding user
$hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

    if(mysqli_num_rows($result) > 0){
        $_SESSION['user'] = $username;
        header("Location: dashboard.php");
    } else {
        echo "Invalid Login";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Admin Login</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Username"><br>
        <input type="password" name="password" placeholder="Password"><br>
        <button name="login">Login</button>
    </form>
</div>

</body>
</html>
