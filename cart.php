<?php
session_start();

// Include database connection
include('includes/db.php');
include('includes/header.php'); // Include the header file

// Check if cart is empty
$cart = $_SESSION['cart'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Your Shopping Cart</h1>

    <?php if (empty($cart)): ?>
        <p>Your cart is empty. <a href="index.php">Shop now</a></p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grandTotal = 0;
                foreach ($cart as $product_id => $quantity):
                    // Fetch product details from the database
                    $stmt = $pdo->prepare("SELECT name, price FROM products WHERE product_id = ?");
                    $stmt->execute([$product_id]);
                    $product = $stmt->fetch();

                    if ($product):
                        $name = htmlspecialchars($product['name']);
                        $price = $product['price'];
                        $total = $price * $quantity;
                        $grandTotal += $total;
                ?>
                <tr>
                    <td><?php echo $name; ?></td>
                    <td><?php echo $quantity; ?></td>
                    <td>$<?php echo number_format($price, 2); ?></td>
                    <td>$<?php echo number_format($total, 2); ?></td>
                    <td>
                        <form action="cart-handler.php" method="POST" style="display:inline-block;">
                            <input type="hidden" name="action" value="remove">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php endif; endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Grand Total</strong></td>
                    <td><strong>$<?php echo number_format($grandTotal, 2); ?></strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <!-- Checkout Form -->
        <h3>Proceed to Checkout</h3>
        <form action="checkout-handler.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Shipping Address</label>
                <textarea class="form-control" id="address" name="address" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Place Order</button>
        </form>

    <?php endif; ?>
</div>
</body>
</html>
