<?php
// Start a new session
session_start();

// Define valid username and password
$valid_username = "admin";
$valid_password = "password123";

// Check if the form is submitted and ensure the REQUEST_METHOD key exists
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the entered username and password match the valid ones
    if ($username === $valid_username && $password === $valid_password) {
        // Successful login
        $_SESSION['user'] = $username; // Store username in session

        // Redirect to a new page (e.g., dashboard), replacing the current history entry
        echo '<script type="text/javascript">
                window.location.replace("main.html");
              </script>';
        exit;
    } else {
        // Failed login
        // Redirect back to login page with an error
        header("Location: login.html?error=Invalid username or password");
        exit;
    }
} else {
    // Redirect back to login page if form is not submitted
    header("Location: login.html");
    exit;
}
?>
