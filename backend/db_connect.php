<?php
$host = "localhost";
$user = "root"; // Update with your MySQL username
$pass = "";     // Update with your MySQL password
$db = "per_diem_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>