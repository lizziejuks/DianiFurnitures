<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary files
include('includes/header.php'); // Header file
include('includes/db.php');     // Database connection

// Fetch the product ID from the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch the product details from the database
    $query = "SELECT * FROM products WHERE product_id = :product_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch();

    // Check if the product exists
    if (!$product) {
        echo "<div class='container mt-5'><h3>Product not found.</h3></div>";
        include('includes/footer.php');
        exit();
    }
} else {
    // Redirect to the products page if no valid ID is provided
    header('Location: products.php');
    exit();
}
?>

<div class="container mt-5">
    <!-- Product Details Section -->
    <h1 class="mb-4"><?php echo htmlspecialchars($product['name']); ?></h1>
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6">
            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                 class="img-fluid">
        </div>
        
        <!-- Product Information -->
        <div class="col-md-6">
            <h3>Description</h3>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <h4>Price: $<?php echo number_format($product['price'], 2); ?></h4>
            <h5>Category: <?php echo htmlspecialchars($product['category']); ?></h5>
            <h5>Stock Quantity: <?php echo htmlspecialchars($product['stock_quantity']); ?></h5>

            <!-- Add to Cart or Other Actions -->
            <form action="cart-handler.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" max="<?php echo $product['stock_quantity']; ?>" required>
                </div>
                <button type="submit" class="btn btn-success">Add to Cart</button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
