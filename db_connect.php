<?php
$servername = "localhost";
$username = "root"; // default XAMPP user
$password = "";     // default empty password in XAMPP
$dbname = "online_bookstore";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
