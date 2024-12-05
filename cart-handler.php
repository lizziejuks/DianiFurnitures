<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Ensure the cart array exists in the session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if the request is a POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the product ID and quantity
    $product_id = $_POST['product_id'] ?? null;
    $quantity = $_POST['quantity'] ?? null;

    // Validate the inputs
    if (!is_numeric($product_id) || !is_numeric($quantity) || $quantity <= 0) {
        header('Location: product-detail.php?id=' . $product_id . '&error=invalid_input');
        exit();
    }

    // Fetch the product details from the database
    include('includes/db.php');
    $query = "SELECT stock_quantity FROM products WHERE product_id = :product_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch();

    // Check if the product exists and stock is sufficient
    if (!$product) {
        header('Location: product-detail.php?id=' . $product_id . '&error=product_not_found');
        exit();
    }

    if ($quantity > $product['stock_quantity']) {
        header('Location: product-detail.php?id=' . $product_id . '&error=stock_exceeded');
        exit();
    }

    // Add or update the item in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }

    // Redirect to the cart page with a success message
    header('Location: cart.php?success=item_added');
    exit();
} else {
    // Redirect if accessed directly
    header('Location: products.php');
    exit();
}
