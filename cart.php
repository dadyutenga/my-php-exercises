<?php
// Start the session
session_start();

// Include database connection
require 'db.php';

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle buying products from the cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buy_items'])) {
    $user_id = $_SESSION['user_id'];

    // Move items from the cart to the sales table
    $cart_items = $conn->query("SELECT * FROM cart WHERE user_id='$user_id'");
    while ($cart_item = $cart_items->fetch_assoc()) {
        $product_id = $cart_item['product_id'];
        $quantity = $cart_item['quantity'];
        $price = $conn->query("SELECT price FROM products WHERE product_id='$product_id'")->fetch_assoc()['price'];

        // Insert the item into the sales table
        $sql = "INSERT INTO sales (user_id, product_id, quantity, price) VALUES ('$user_id', '$product_id', '$quantity', '$price')";
        if ($conn->query($sql) === TRUE) {
            // Remove the item from the cart
            $conn->query("DELETE FROM cart WHERE user_id='$user_id' AND product_id='$product_id'");
        } else {
            echo '<p>Error: ' . $conn->error . '</p>';
        }
    }
    echo '<p>Items purchased successfully!</p>';
}

// Display cart items
$user_id = $_SESSION['user_id'];
$cart_items = $conn->query("SELECT products.*, cart.quantity FROM products JOIN cart ON products.product_id=cart.product_id WHERE cart.user_id='$user_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Include your stylesheet -->
</head>
<body>

    <h2>Shopping Cart</h2>

    <?php
    while ($cart_item = $cart_items->fetch_assoc()) {
        echo '<div>';
        echo '<h3>' . $cart_item['name'] . '</h3>';
        echo '<p>Price: $' . $cart_item['price'] . '</p>';
        echo '<p>Quantity: ' . $cart_item['quantity'] . '</p>';
        echo '<img src="' . $cart_item['image_url'] . '" alt="' . $cart_item['name'] . '" style="max-width: 100px;">';
        echo '</div>';
        echo '<hr>';
    }
    ?>

    <form action="cart.php" method="post">
        <button type="submit" name="buy_items">Buy Items</button>
    </form>

    <p><a href="index.php">Back to Product Catalog</a></p>

</body>
</html>
