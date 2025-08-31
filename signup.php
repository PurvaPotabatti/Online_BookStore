<?php
// Database connection
$host = "localhost";
$user = "root";       // default in XAMPP
$pass = "";           // default is empty in XAMPP
$db   = "online_bookstore";  // make sure you created this database

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email    = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Insert into users table
    $sql = "INSERT INTO users (username, email, password) 
            VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        // success → go to index.html
        header("Location: signin.html");
        exit();
    } else {
        // Check for duplicate entry (error code 1062 in MySQL)
        if ($conn->errno == 1062) {
            echo "<script>alert('Username or Email already exists! Please choose another.'); window.location.href='signup.html';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
