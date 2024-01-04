<?php
// Start the session
session_start();

// Include database connection
require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Include your stylesheet -->
</head>
<body>

    <h2>Product Catalog</h2>

    <?php
    // Redirect to login if user is not logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    // Handle adding products to the cart
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
        $product_id = $_POST['product_id'];
        $user_id = $_SESSION['user_id'];

        // Insert product into the cart
        $sql = "INSERT INTO cart (user_id, product_id) VALUES ('$user_id', '$product_id')";
        if ($conn->query($sql) === TRUE) {
            echo '<p>Item added to the cart.</p>';
        } else {
            echo '<p>Error: ' . $conn->error . '</p>';
        }
    }

    // Display products
    $result = $conn->query("SELECT * FROM products");
    while ($row = $result->fetch_assoc()) {
        echo '<div>';
        echo '<h3>' . $row['name'] . '</h3>';
        echo '<p>' . $row['description'] . '</p>';
        echo '<p>Price: $' . $row['price'] . '</p>';
        echo '<img src="' . $row['image_url'] . '" alt="' . $row['name'] . '" style="max-width: 100px;">';
        echo '<form action="index.php" method="post">';
        echo '<input type="hidden" name="product_id" value="' . $row['product_id'] . '">';
        echo '<button type="submit" name="add_to_cart">Add to Cart</button>';
        echo '</form>';
        echo '</div>';
        echo '<hr>';
    }
    ?>

    <p>
        <a href="cart.php">View Cart</a> | 
        <?php
        if (isset($_SESSION['user_id'])) {
            echo '<a href="logout.php">Logout</a>';
        }
        ?>
    </p>

</body>
</html>
