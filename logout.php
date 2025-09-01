<?php
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to homepage with logout message
echo "<script>
    localStorage.removeItem('booklyUser');
    alert('You have been successfully logged out.');
    window.location.href='index.html';
</script>";
?>
