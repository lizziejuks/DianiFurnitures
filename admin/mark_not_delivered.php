<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../includes/db.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if order ID is provided
    if (!isset($_POST['id']) || empty($_POST['id'])) {
        echo json_encode(['status' => 'error', 'message' => 'No order ID provided.']);
        exit();
    }

    $order_id = intval($_POST['id']); // Sanitize order ID

    try {
        $query = "UPDATE orders SET status = 'pending' WHERE order_id = :order_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();

        // Return success response
        echo json_encode(['status' => 'success', 'message' => 'Order marked as not delivered.']);
        exit();
    } catch (PDOException $e) {
        // Return error response
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
        exit();
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit();
}
?>
