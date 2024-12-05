<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Include database connection
include('includes/db.php');

// Check if cart is empty
if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

// Check if POST request is made
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture form data
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $address = $_POST['address'] ?? null;

    // Validate the inputs
    if (!$name || !$email || !$address) {
        echo "All fields are required!";
        exit();
    }

    // Assuming the user is logged in, get the user_id from the session
    // If the user is not logged in, you can handle this differently, e.g., asking for a guest user ID
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        echo "User is not logged in.";
        exit();
    }

    // Prepare order data
    $orderDate = date('Y-m-d H:i:s');
    $status = 'pending';
    $totalAmount = 0;

    // Insert order into database
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, order_date, status) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $totalAmount, $orderDate, $status]);

    // Get the last inserted order ID
    $orderId = $pdo->lastInsertId();

    // Insert order items into order_items table
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        // Fetch product price
        $stmt = $pdo->prepare("SELECT price FROM products WHERE product_id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();

        if ($product) {
            $price = $product['price'];
            $total = $price * $quantity;
            $totalAmount += $total;

            // Insert into order_items table
            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price, total) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$orderId, $product_id, $quantity, $price, $total]);
        }
    }

    // Update the total amount in the orders table
    $stmt = $pdo->prepare("UPDATE orders SET total_amount = ? WHERE order_id = ?");
    $stmt->execute([$totalAmount, $orderId]);

    // Clear the cart after checkout
    unset($_SESSION['cart']);

    // Redirect to a confirmation page
    header('Location: order-confirmation.php?order_id=' . $orderId);
    exit();
} else {
    // If accessed without POST request, redirect to cart
    header('Location: cart.php');
    exit();
}
