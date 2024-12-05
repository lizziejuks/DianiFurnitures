<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
include('../includes/db.php');

// Handle product addition
if (isset($_POST['add_product'])) {
    // Get the product details from the form
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock_quantity = $_POST['stock_quantity'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);

        // Validate image file extension and size
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($image_ext), $allowed_extensions) && $image_size <= 5000000) {
            // Generate a unique name for the image and set the upload path
            $image_new_name = uniqid('product_', true) . '.' . $image_ext;
            $image_upload_path = '../img/' . $image_new_name;

            // Ensure the directory exists and is writable
            if (!file_exists('../img/')) {
                mkdir('../img/', 0777, true); // Create directory if not exists
            }

            if (is_writable('../img/')) {
                // Move the uploaded image to the target directory
                if (move_uploaded_file($image_tmp_name, $image_upload_path)) {
                    // Insert product details into the database
                    $query = "INSERT INTO products (name, description, price, image_url, category, stock_quantity) 
                              VALUES (:name, :description, :price, :image_url, :category, :stock_quantity)";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':image_url', $image_upload_path);
                    $stmt->bindParam(':category', $category);
                    $stmt->bindParam(':stock_quantity', $stock_quantity);
                    $stmt->execute();

                    $success_message = "Product added successfully!";
                } else {
                    $error_message = "Error uploading the image. Please try again.";
                }
            } else {
                $error_message = "The image directory is not writable.";
            }
        } else {
            $error_message = "Invalid image file. Only JPG, JPEG, PNG, and GIF files are allowed, and the size should be less than 5MB.";
        }
    } else {
        $error_message = "Please select an image to upload.";
    }
}

// Handle product deletion
if (isset($_GET['delete_id'])) {
    try {
        $delete_id = $_GET['delete_id'];

        // Delete product from the database
        $query = "DELETE FROM products WHERE product_id = :product_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':product_id', $delete_id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect to the same page
        header("Location: manage_products.php");
        exit();
    } catch (PDOException $e) {
        echo "Error deleting product: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <!-- Form for adding products -->
    <h3>Add New Product</h3>
    <form action="manage_products.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" required></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" name="price" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" class="form-control" name="category" required>
        </div>
        <div class="mb-3">
            <label for="stock_quantity" class="form-label">Stock Quantity</label>
            <input type="number" class="form-control" name="stock_quantity" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" class="form-control" name="image" accept="image/*" required>
        </div>
        <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
    </form>

    <!-- Display success or error messages -->
    <?php
    if (isset($success_message)) {
        echo "<div class='alert alert-success mt-3'>$success_message</div>";
    } elseif (isset($error_message)) {
        echo "<div class='alert alert-danger mt-3'>$error_message</div>";
    }
    ?>

    <!-- Display Products Table -->
    <h4 class="mt-4">Existing Products</h4>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch products from the database
                    $query = "SELECT product_id, name, description, price, image_url, category, stock_quantity FROM products";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $products = $stmt->fetchAll();

                    // Display each product in a table row
                    foreach ($products as $product) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($product['product_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($product['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($product['description']) . "</td>";
                        echo "<td>" . htmlspecialchars($product['price']) . "</td>";
                        echo "<td><img src='" . htmlspecialchars($product['image_url']) . "' alt='" . htmlspecialchars($product['name']) . "' style='width:50px;'></td>";
                        echo "<td>" . htmlspecialchars($product['category']) . "</td>";
                        echo "<td>" . htmlspecialchars($product['stock_quantity']) . "</td>";
                        echo "<td>
                                <a href='manage_products.php?delete_id=" . $product['product_id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this product?\")'>Delete</a>
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
