<?php
$conn = new mysqli("localhost", "root", "", "infosec_lab");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>