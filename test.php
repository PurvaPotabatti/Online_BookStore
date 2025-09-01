<?php
// Simple test file to verify PHP is working
echo "<!DOCTYPE html>
<html>
<head>
    <title>PHP Test</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .success { color: green; background: #e8f5e8; padding: 15px; border-radius: 5px; }
        .info { color: blue; background: #e3f2fd; padding: 15px; border-radius: 5px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>✅ PHP Server Test</h1>
    
    <div class='success'>
        <h3>PHP is working correctly!</h3>
        <p>Server: " . $_SERVER['SERVER_SOFTWARE'] . "</p>
        <p>PHP Version: " . phpversion() . "</p>
        <p>Request Method: " . $_SERVER['REQUEST_METHOD'] . "</p>
    </div>
    
    <div class='info'>
        <h3>Test POST Request</h3>
        <form method='post' action='test.php'>
            <input type='text' name='test_input' placeholder='Enter something to test POST' style='padding: 8px; margin: 10px; width: 200px;'>
            <button type='submit' style='padding: 8px 16px; background: #0FA4AF; color: white; border: none; border-radius: 4px; cursor: pointer;'>Test POST</button>
        </form>
    </div>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<div class='success'>
        <h3>✅ POST Request Successful!</h3>
        <p>You entered: <strong>" . htmlspecialchars($_POST['test_input'] ?? 'nothing') . "</strong></p>
        <p>This confirms that POST requests are working correctly.</p>
    </div>";
}

echo "<p><a href='index.html' style='color: #0FA4AF;'>← Back to Homepage</a></p>
</body>
</html>";
?>
