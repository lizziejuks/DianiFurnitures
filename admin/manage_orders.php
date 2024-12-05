<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../includes/db.php'); // Include database connection
?>

<div class="container-fluid">
    <h2 class="mt-4">Manage Orders</h2>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Order Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch orders from the database
                    $query = "SELECT orders.order_id, users.username AS user_name, orders.order_date, orders.total_amount, orders.status
                            FROM orders
                            JOIN users ON orders.user_id = users.user_id";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $orders = $stmt->fetchAll();

                    // Display each order in a table row
                    foreach ($orders as $order) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($order['order_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['user_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['order_date']) . "</td>";
                        echo "<td>$" . number_format($order['total_amount'], 2) . "</td>";
                        echo "<td class='order-status'>
                                <span class='badge " . 
                                    ($order['status'] == 'pending' ? 'bg-warning' : 
                                    ($order['status'] == 'completed' ? 'bg-success' : 'bg-danger')) . 
                                    "'>" . ucfirst($order['status']) . "</span>
                              </td>";
                        echo "<td>
                                <button class='btn btn-success btn-sm approve-order' data-id='" . $order['order_id'] . "'>Approve</button>
                                <a href='mark_delivered.php?id=" . $order['order_id'] . "' class='btn btn-info btn-sm'>Mark as Delivered</a>
                                <a href='mark_not_delivered.php?id=" . $order['order_id'] . "' class='btn btn-warning btn-sm'>Mark as Not Delivered</a>
                                <a href='delete_order.php?id=" . $order['order_id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this order?\")'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const approveButtons = document.querySelectorAll('.approve-order');

    approveButtons.forEach(button => {
        button.addEventListener('click', event => {
            event.preventDefault();
            const orderId = button.getAttribute('data-id');

            // Send AJAX request
            fetch('approve_order.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: orderId })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        // Update the status in the table dynamically
                        const statusCell = button.closest('tr').querySelector('.order-status span');
                        statusCell.textContent = 'Completed';
                        statusCell.classList.remove('bg-warning', 'bg-danger');
                        statusCell.classList.add('bg-success');
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
