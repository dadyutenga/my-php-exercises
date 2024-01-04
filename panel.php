<?php
// Start the session
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the admin login page if not logged in
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style1.css"> <!-- Include your external stylesheet -->

    <!-- Optional: Include additional CSS styles for the dashboard -->
    <style>
        /* Add your additional styles here */
    </style>
</head>
<body>

    <h2>Welcome to the Admin Dashboard, <?php echo $_SESSION['admin_username']; ?>!</h2>

    <div class="options">
        <ul>
            <li><a href="product.php">Product CRUD</a></li>
            <li><a href="user.php">User CRUD</a></li>
            <li><a href="report_sales.php">Report Sales</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Add additional content or information about the dashboard -->

</body>
</html>
