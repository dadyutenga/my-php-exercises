<?php
// Include database connection
require 'db.php';

// Function to display products
function displayProducts($conn)
{
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>ID</th><th>Name</th><th>Price</th><th>Description</th><th>Image URL</th><th>Actions</th></tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['product_id'] . '</td>';
            echo '<td>' . $row['name'] . '</td>';
            echo '<td>' . $row['price'] . '</td>';
            echo '<td>' . $row['description'] . '</td>';
            echo '<td>' . $row['image_url'] . '</td>';
            echo '<td>';
            echo '<a href="?action=edit&id=' . $row['product_id'] . '">Edit</a>';
            echo ' | ';
            echo '<a href="?action=delete&id=' . $row['product_id'] . '">Delete</a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No products found.';
    }
}

// Handle actions (add, edit, delete)
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'add':
            // Handle add product logic (similar to your previous code)
            break;
        case 'edit':
            // Handle edit product logic
            if (isset($_GET['id'])) {
                // Fetch product details by ID and populate the form for editing
                $productId = $_GET['id'];
                $sqlFetchProduct = "SELECT * FROM products WHERE product_id='$productId'";
                $result = $conn->query($sqlFetchProduct);

                if ($result->num_rows > 0) {
                    $product = $result->fetch_assoc();
                    // Populate the form for editing
                    $product_id = $product['product_id'];
                    $product_name = $product['name'];
                    $product_price = $product['price'];
                    $product_description = $product['description'];
                    $image_url = $product['image_url'];
                }
            }
            break;
        case 'delete':
            // Handle delete product logic
            if (isset($_GET['id'])) {
                $productId = $_GET['id'];
                $sqlDeleteProduct = "DELETE FROM products WHERE product_id='$productId'";
                $conn->query($sqlDeleteProduct);
            }
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Dashboard</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h2>Product Dashboard</h2>

    <?php
    // Display products
    displayProducts($conn);
    ?>

    <h3>Actions</h3>
    <ul>
        <li><a href="?action=add">Add Product</a></li>
        <li><a href="index.php">Back to Dashboard</a></li>
    </ul>

    <?php
    // Include the form for adding/editing product (use the variables set in the switch case)
    include 'product_form.php';
    ?>

</body>
</html>
