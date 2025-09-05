<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Accept either username or email
    $usernameOrEmail = isset($_POST['username']) ? trim($_POST['username']) : trim($_POST['email']);
    $password = $_POST['password'] ?? '';

    $errors = [];

    if (empty($usernameOrEmail)) {
        $errors[] = "Email or Username is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if (empty($errors)) {
        try {
            $pdo = getDBConnection();

            // Check by username OR email
            $stmt = $pdo->prepare("SELECT id, username, email, password FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$usernameOrEmail, $usernameOrEmail]);
            $user = $stmt->fetch();

            if (!$user) {
                echo "<script>
                        alert('This email/username is not registered. Please sign up first.');
                        window.location.href = 'signup.html';
                      </script>";
                exit;
            }

            if ($user && !password_verify($password, $user['password'])) {
                $errors[] = "Invalid password";
            }

            if (empty($errors)) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['is_logged_in'] = true;

                // ✅ Also persist lightweight info in localStorage for static pages
                echo "<script>
                        try {
                          localStorage.setItem('booklyUser', JSON.stringify({
                            is_logged_in: true,
                            name: '" . addslashes($user['username']) . "',
                            email: '" . addslashes($user['email']) . "'
                          }));
                        } catch (e) {}
                        alert('Successfully signed in!');
                        window.location.href = 'index.html';
                      </script>";
                exit;
            }
        } catch (PDOException $e) {
            $errors[] = "Login failed: " . $e->getMessage();
        }
    }

    if (!empty($errors)) {
        echo "<script>
                alert('".implode("\\n", $errors)."');
                window.location.href = 'signin.html';
              </script>";
        exit;
    }
}

// If not POST, redirect
header('Location: signin.html');
exit;
?>
