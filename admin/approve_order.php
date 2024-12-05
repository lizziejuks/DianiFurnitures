<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../includes/db.php'); // Include database connection

// Get the input data from the fetch request
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['id']) && !empty($input['id'])) {
    $order_id = intval($input['id']); // Sanitize the order ID

    try {
        // Update order status to 'completed'
        $query = "UPDATE orders SET status = 'completed' WHERE order_id = :order_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();

        // Return a success response
        echo json_encode(['status' => 'success', 'message' => 'Order approved successfully.']);
    } catch (PDOException $e) {
        // Return an error response if something goes wrong
        echo json_encode(['status' => 'error', 'message' => 'Error approving order: ' . $e->getMessage()]);
    }
} else {
    // Return an error if no order ID is provided
    echo json_encode(['status' => 'error', 'message' => 'No order ID provided.']);
}
?>
