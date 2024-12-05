<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../includes/db.php'); // Include database connection

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "No order ID provided.";
    exit();
}

$order_id = intval($_GET['id']); // Sanitize order ID

try {
    $pdo->beginTransaction();

    // Delete associated items
    $query_items = "DELETE FROM order_items WHERE order_id = :order_id";
    $stmt_items = $pdo->prepare($query_items);
    $stmt_items->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt_items->execute();

    // Delete the order
    $query_order = "DELETE FROM orders WHERE order_id = :order_id";
    $stmt_order = $pdo->prepare($query_order);
    $stmt_order->bindParam(':order_id', $order_id, PDO::PARAM_INT);
    $stmt_order->execute();

    $pdo->commit();
    echo "Order deleted successfully.";
    header('Location: manage_orders.php'); // Redirect to manage orders page
    exit();
} catch (PDOException $e) {
    $pdo->rollBack();
    echo "Error deleting order: " . $e->getMessage();
}
?>
