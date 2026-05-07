<?php
session_start();
session_unset();
// Destroy all session data
session_destroy();

// Redirect to login page
header("Location: login.php");
exit();
?>
