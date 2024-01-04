<?php
// Start the session
session_start();

// Include database connection
require 'db.php';

// Handle admin login logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['admin_login'])) {
    $admin_username = $_POST['admin_username'];
    $admin_password = $_POST['admin_password'];

    // Check if the entered admin credentials are valid
    $sql = "SELECT * FROM admin WHERE username='$admin_username' AND password='$admin_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Admin authentication successful
        $_SESSION['admin_id'] = $result->fetch_assoc()['admin_id'];
        $_SESSION['admin_username'] = $admin_username;

        // Redirect to the admin panel or perform admin-specific tasks
        header("Location: panel.php");
        exit();
    } else {
        echo '<p>Invalid admin username or password. Please try again.</p>';
    }
}

// ... rest of your HTML for the admin login form ...
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Include your stylesheet -->
</head>
<body>

    <h2>Admin Login</h2>

    <form action="admin.php" method="post">
        <label for="admin_username">Admin Username:</label>
        <input type="text" name="admin_username" required>

        <label for="admin_password">Admin Password:</label>
        <input type="password" name="admin_password" required>

        <button type="submit" name="admin_login">Admin Login</button>
    </form>

</body>
</html>

