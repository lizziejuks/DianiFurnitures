<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}

include('includes/db.php'); // Include database connection
include('includes/header.php'); // Include header with navigation

$user_id = $_SESSION['user_id']; // Get user_id from session

?>

<div class="container-fluid">
    <h2 class="mt-4">My Orders</h2>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch orders for the logged-in customer
                    $query = "SELECT orders.order_id, orders.order_date, orders.total_amount, orders.status
                            FROM orders
                            WHERE orders.user_id = :user_id";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $orders = $stmt->fetchAll();

                    // Display each order in a table row
                    if ($orders) {
                        foreach ($orders as $order) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($order['order_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($order['order_date']) . "</td>";
                            echo "<td>$" . number_format($order['total_amount'], 2) . "</td>";
                            echo "<td class='order-status'>
                                    <span class='badge " . 
                                        ($order['status'] == 'pending' ? 'bg-warning' : 
                                        ($order['status'] == 'completed' ? 'bg-success' : 'bg-danger')) . 
                                        "'>" . ucfirst($order['status']) . "</span>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No orders found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Optional Footer Section -->
<?php include('includes/footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
