<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
include('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Retrieve and sanitize the form inputs
        $name = htmlspecialchars($_POST['name']);
        $description = htmlspecialchars($_POST['description']);
        $price = floatval($_POST['price']);
        $category = htmlspecialchars($_POST['category']);
        $stock_quantity = intval($_POST['stock_quantity']);

        // Handle image upload
        $image_url = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageDir = "img/products/";
        $imagePath = $imageDir . basename($image_url);

        // Check if the image file is a valid image type
        $imageFileType = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.']);
            exit;
        }

        if (!move_uploaded_file($imageTmp, $imagePath)) {
            echo json_encode(['success' => false, 'message' => 'Failed to upload the image.']);
            exit;
        }

        // Insert the data into the database
        $query = "INSERT INTO products (name, description, price, image_url, category, stock_quantity, created_at) 
                  VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$name, $description, $price, $image_url, $category, $stock_quantity]);

        echo json_encode(['success' => true, 'message' => 'Product added successfully!']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}
?>


<div class="container mt-5">
    <h2 class="text-center mb-4">Add New Product</h2>
    <form id="add-product-form" enctype="multipart/form-data">
        <!-- Product Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <!-- Product Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Product Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>

        <!-- Product Price -->
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
        </div>

        <!-- Product Category -->
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" class="form-control" id="category" name="category" required>
        </div>

        <!-- Product Stock Quantity -->
        <div class="mb-3">
            <label for="stock_quantity" class="form-label">Stock Quantity</label>
            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" required>
        </div>

        <!-- Product Image -->
        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" class="form-control" id="image" name="image" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100">Add Product</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#add-product-form').on('submit', function (e) {
            e.preventDefault(); // Prevent default form submission
            const formData = new FormData(this); // Gather form data
            
            $.ajax({
                url: 'add_products.php', // Server-side script
                type: 'POST',
                data: formData,
                processData: false, // Prevent jQuery from processing data
                contentType: false, // Prevent jQuery from setting content type
                success: function (response) {
                    const res = JSON.parse(response);
                    if (res.success) {
                        alert(res.message);
                        $('#add-product-form')[0].reset(); // Reset the form
                    } else {
                        alert(res.message); // Show error message
                    }
                },
                error: function () {
                    alert('An error occurred while processing the request.');
                }
            });
        });
    });
</script>

<?php
include('../includes/footer.php'); // Include footer
?>
