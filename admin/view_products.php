<?php
include('../includes/db.php'); // Include database connection

?>

<div class="container-fluid">
    <h2 class="mt-4">Products</h2>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Stock Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch products from the database
                    $query = "SELECT * FROM products";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $products = $stmt->fetchAll();

                    // Display each product in a table row
                    foreach ($products as $product) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($product['product_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($product['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($product['description']) . "</td>";
                        echo "<td>$" . number_format($product['price'], 2) . "</td>";
                        echo "<td>" . htmlspecialchars($product['category']) . "</td>";
                        echo "<td>" . htmlspecialchars($product['stock_quantity']) . "</td>";
                        echo "<td>
                                <a href='edit_product.php?id=" . $product['product_id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='delete_product.php?id=" . $product['product_id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this product?\")'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
