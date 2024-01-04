<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Include your stylesheet -->
</head>
<body>

    <h2>User Registration</h2>

    <?php
    // Start the session
    session_start();

    // Handle registration logic here
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Include database connection
        require 'db.php';

        $username = $_POST['username'];
        $password = $_POST['password'];

        // Insert user data into the 'users' table
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            // Set session variables
            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['username'] = $username;

            echo '<p>Registration successful. You are now logged in. Redirecting to <a href="index.php">index.php</a>.</p>';
            echo '<script>setTimeout(function(){ window.location.href = "index.php"; }, 2000);</script>';
        } else {
            echo '<p>Error: ' . $conn->error . '</p>';
        }

        // Close the database connection
        $conn->close();
    }
    ?>

    <form action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Register</button>
    </form>

</body>
</html>
