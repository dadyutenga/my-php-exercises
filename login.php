<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Include your stylesheet -->
</head>
<body>

    <h2>User Login</h2>

    <?php
    // Start the session
    session_start();

    // Handle login logic here
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Include database connection
        require 'db.php';

        $username = $_POST['username'];
        $password = $_POST['password'];

        // Check if the entered credentials are valid for regular users
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Set session variables for regular users
            $_SESSION['user_id'] = $result->fetch_assoc()['user_id'];
            $_SESSION['username'] = $username;

            // Redirect to index.php after successful login
            header("Location: index.php");
            exit();
        } else {
            // Check if the entered credentials are valid for admin users
            $sqlAdmin = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
            $resultAdmin = $conn->query($sqlAdmin);

            if ($resultAdmin->num_rows > 0) {
                // Set session variables for admin users
                $_SESSION['admin_id'] = $resultAdmin->fetch_assoc()['admin_id'];
                $_SESSION['admin_username'] = $username;

                // Redirect to admin_panel.php after successful admin login
                header("Location: admin_panel.php");
                exit();
            } else {
                echo '<p>Invalid username or password. Please try again.</p>';
            }
        }

        // Close the database connection
        $conn->close();
    }
    ?>

    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <!-- Button for admin login -->
    <form action="admin.php" method="post">
        <button type="submit" name="admin_login">Admin Login</button>
    </form>

</body>
</html>
