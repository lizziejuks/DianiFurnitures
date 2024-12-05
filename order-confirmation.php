<?php
session_start();
include('includes/db.php');

// Get order ID from the URL
$order_id = $_GET['order_id'] ?? null;

if (!$order_id) {
    echo "Order not found.";
    exit();
}

// Fetch the order details
$stmt = $pdo->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if (!$order) {
    echo "Order not found.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Order Confirmation</h1>

    <p><strong>Order ID:</strong> <?php echo $order['order_id']; ?></p>
    <p><strong>Order Date:</strong> <?php echo $order['order_date']; ?></p>
    <p><strong>Total Amount:</strong> $<?php echo number_format($order['total_amount'], 2); ?></p>
    <p><strong>Status:</strong> <?php echo ucfirst($order['status']); ?></p>

    <h3>Order Items</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch the items for this order
            $stmt = $pdo->prepare("SELECT oi.*, p.name FROM order_items oi JOIN products p ON oi.product_id = p.product_id WHERE oi.order_id = ?");
            $stmt->execute([$order_id]);
            $items = $stmt->fetchAll();

            foreach ($items as $item):
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td>$<?php echo number_format($item['total'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p><a href="index.php" class="btn btn-primary">Continue Shopping</a></p>
</div>
</body>
</html>
