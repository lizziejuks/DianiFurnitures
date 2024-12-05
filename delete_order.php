<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
require_once 'includes/db.php';

// Check if order ID is provided
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    echo "No order ID provided.";
    exit();
}

$order_id = intval($_GET['order_id']); // Sanitize the order ID

try {
    // Start a transaction
    $pdo->beginTransaction();

    // Delete order items associated with the order
    $stmt = $pdo->prepare("DELETE FROM order_items WHERE order_id = ?");
    $stmt->execute([$order_id]);

    // Delete the order itself
    $stmt = $pdo->prepare("DELETE FROM orders WHERE order_id = ?");
    $stmt->execute([$order_id]);

    // Commit the transaction
    $pdo->commit();

    echo "Order and its items successfully deleted.";
    // Optionally, redirect the user to another page
    // header("Location: orders.php?status=deleted");
    // exit();
} catch (PDOException $e) {
    // Rollback transaction on error
    $pdo->rollBack();
    echo "Error deleting order: " . $e->getMessage();
}
?>
