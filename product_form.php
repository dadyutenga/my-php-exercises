<!-- product_form.php -->

<?php
// Include database connection
require 'db.php';

// Check if product details are available for editing
if (isset($product_id)) {
    $formAction = "product.php?action=update_product";
    $formTitle = "Edit Product";
} else {
    $formAction = "product.php?action=add_product";
    $formTitle = "Add Product";
}

// Initialize variables to store form data
$product_name = '';
$product_price = '';
$product_quantity = '';
$product_description = '';
$product_image = '';

// If editing, populate form fields with existing data
if (isset($product_id)) {
    $sqlFetchProduct = "SELECT * FROM products WHERE product_id='$product_id'";
    $result = $conn->query($sqlFetchProduct);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $product_name = $product['name'];
        $product_price = $product['price'];
        $product_quantity = $product['quantity'];
        $product_description = $product['description'];
        // 'image_url' should be set from your database column
        $product_image = $product['image_url'];
    }
}
?>

<h3><?php echo $formTitle; ?></h3>

<form action="<?php echo $formAction; ?>" method="post" enctype="multipart/form-data">
    <?php if (isset($product_id)) : ?>
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
    <?php endif; ?>

    <label for="product_name">Product Name:</label>
    <input type="text" name="product_name" value="<?php echo $product_name; ?>" required>

    <label for="product_price">Product Price:</label>
    <input type="number" name="product_price" value="<?php echo $product_price; ?>" required>

    <label for="product_quantity">Product Quantity:</label>
    <input type="number" name="product_quantity" value="<?php echo $product_quantity; ?>" required>

    <label for="product_description">Product Description:</label>
    <textarea name="product_description"><?php echo $product_description; ?></textarea>

    <label for="product_image">Product Image:</label>
    <input type="file" name="product_image">

    <button type="submit" name="<?php echo isset($product_id) ? 'update_product' : 'add_product'; ?>">
        <?php echo isset($product_id) ? 'Update Product' : 'Add Product'; ?>
    </button>
</form>
