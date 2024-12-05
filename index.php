<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary files
include('includes/header.php');  // Include the header.php file
include('includes/db.php');  // Include the database connection

// Fetch products from the database
$query = "SELECT * FROM products";
$stmt = $pdo->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll();
?>

<div class="container mt-5">
    <!-- Welcome Section -->
    <h1 class="text-center mb-4">Welcome to Our Furniture Store!</h1>
    <p class="text-center mb-5">Browse our collection of quality furniture and find the perfect pieces for your home.</p>

    <!-- About Us Section -->
    <div class="about-us mb-5">
        <h2 class="text-center mb-4">About Us</h2>
        <p class="text-center">
            At Diani Furniture Store, we pride ourselves on offering high-quality furniture designed to suit every taste and style. 
            Our mission is to transform your home into a space that reflects your personality and meets your comfort needs.
        </p>
        <div class="text-center mt-3">
            <a href="about.php" class="btn btn-primary">Read More</a>
        </div>
    </div>

    <!-- Our Products Section -->
    <div class="products mb-5">
        <h2 class="text-center mb-4">Our Products</h2>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                    <img src="<?php echo !empty($product['image_url']) ? htmlspecialchars($product['image_url']) : 'img/default.jpg'; ?>" 
alt="<?php echo htmlspecialchars($product['name']); ?>" />


                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name'] ?? 'No Name'); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($product['description'] ?? 'No description available'); ?></p>
                            <p class="card-text"><strong>Price: $<?php echo number_format($product['price'] ?? 0, 2); ?></strong></p>
                            <a href="product-detail.php?id=<?php echo htmlspecialchars($product['product_id']); ?>" class="btn btn-primary w-100">View</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Contact Us Section -->
    <div class="contact-us">
        <h2 class="text-center mb-4">Contact Us</h2>
        <div class="row">
            <!-- Contact Details -->
            <div class="col-md-6 mb-4">
                <h5>Get in Touch</h5>
                <p><i class="bi bi-envelope"></i> Email: support@dianifurniture.com</p>
                <p><i class="bi bi-telephone"></i> Phone: +123 456 7890</p>
                <p><i class="bi bi-geo-alt"></i> Address: 123 Furniture Street, Diani</p>
            </div>

            <!-- Contact Form -->
            <div class="col-md-6">
                <h5>Send Us a Message</h5>
                <form action="contact-handler.php" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');  // Include the footer.php file
?>
