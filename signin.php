<?php
// Database connection
$host = "localhost";
$user = "root";       // default in XAMPP
$pass = "";           // default is empty
$db   = "online_bookstore";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Fetch user
    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Success → Start session
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: index.html");
            exit();
        } else {
            echo "<script>alert('Invalid password!'); window.location.href='signin.html';</script>";
        }
    } else {
        echo "<script>alert('No account found with this email! Please sign up first.'); window.location.href='signup.html';</script>";
    }
}
$conn->close();
?>
