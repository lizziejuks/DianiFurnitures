<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary files
include('includes/db.php'); // Include the database connection
include('includes/header.php'); // Include the header file

// Fetch products from the database
$query = "SELECT * FROM products";
$stmt = $pdo->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4">Our Products</h1>
    <div class="row">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <!-- Product Image -->
                        <img 
                            src="<?php echo htmlspecialchars($product['image_url']); ?>" 
                            alt="<?php echo htmlspecialchars($product['name']); ?>" 
                            class="card-img-top" 
                            style="height: 200px; object-fit: cover;">
                        
                        <div class="card-body">
                            <!-- Product Name -->
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <!-- Product Description -->
                            <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                            <!-- Product Price -->
                            <p class="card-text"><strong>Price: $<?php echo number_format($product['price'], 2); ?></strong></p>
                            <!-- View Details Button -->
                            <a href="product-detail.php?id=<?php echo htmlspecialchars($product['product_id']); ?>" class="btn btn-primary w-100">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No products found.</p>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include('includes/footer.php'); ?>
