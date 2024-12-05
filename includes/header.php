<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start session only if it's not already active
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furniture Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles for the navbar */
        .navbar {
            background-color: #29AB87; /* Jungle Green background */
        }

        .navbar .navbar-nav .nav-link {
            color: #000000; /* Black color for the navbar links */
        }

        .navbar .navbar-nav .nav-link:hover {
            color: #ffffff; /* White color on hover */
        }

        .navbar .navbar-brand {
            font-size: 1.5rem;
            color: #000000; /* Black color for the brand */
        }

        .navbar .navbar-brand:hover {
            color: #ffffff; /* White on hover */
        }

        .navbar .navbar-logo {
            height: 40px; /* Adjust the height of the logo */
            margin-right: 10px; /* Space between logo and brand name */
        }

        .carousel-inner img {
            width: 100%;
            height: 60vh; /* Adjust the height of banners */
            object-fit: cover;
        }

        .carousel-caption {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .carousel-caption h3 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .carousel-caption p {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a href="index.php" class="d-flex align-items-center">
                <img src="img/logo.jpeg" alt="Furniture Store Logo" class="navbar-logo">
            </a>
            <a class="navbar-brand" href="index.php">Diani Furniture Store</a>

            <!-- Navbar Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="categories.php">Categories</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="myorders.php">My Orders</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section: Carousel -->
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/banner4.jpg" class="d-block w-100" alt="Banner 1">
                <div class="carousel-caption">
                    <h3>Welcome to Our Furniture Store</h3>
                    <p>Explore quality furniture crafted for every room in your home.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/banner5.jpg" class="d-block w-100" alt="Banner 2">
                <div class="carousel-caption">
                    <h3>Style and Comfort</h3>
                    <p>Discover furniture that combines beauty and functionality.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/banner6.jpg" class="d-block w-100" alt="Banner 3">
                <div class="carousel-caption">
                    <h3>Exclusive Deals</h3>
                    <p>Shop now and save on our best furniture collections.</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
