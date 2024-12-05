<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary files
include('includes/header.php');
?>

<div class="container mt-5">
    <!-- About Us Section -->
    <h1 class="text-center mb-4">About Us</h1>
    <div class="about-content mb-5">
        <p class="text-center">
            At Diani Furniture Store, we believe that furniture is more than just utility—it's about creating a home that reflects your personality and style. 
            Founded in 2010, we have dedicated ourselves to providing high-quality, stylish, and durable furniture that enhances the comfort and aesthetics of your home.
        </p>
        <p class="text-center">
            Our team of skilled artisans and designers work tirelessly to craft furniture that meets global standards while preserving local craftsmanship traditions. 
            From modern designs to timeless classics, our collection has something for everyone.
        </p>
    </div>

    <!-- Mission and Vision -->
    <div class="row mb-5">
        <div class="col-md-6">
            <h3>Our Mission</h3>
            <p>
                To provide top-quality furniture that combines functionality, comfort, and style, enhancing the living experience of our customers.
            </p>
        </div>
        <div class="col-md-6">
            <h3>Our Vision</h3>
            <p>
                To become a trusted household name for furniture, recognized for exceptional quality, innovative designs, and outstanding customer service.
            </p>
        </div>
    </div>

    <!-- Our Services -->
    <h2 class="text-center mb-4">Our Services</h2>
    <div class="services mb-5">
        <div class="row">
            <!-- Delivery Service -->
            <div class="col-md-4 text-center mb-4">
                <i class="bi bi-truck" style="font-size: 2rem; color: #29AB87;"></i>
                <h4 class="mt-3">Fast & Reliable Delivery</h4>
                <p>
                    We ensure your orders are delivered right to your doorstep, safely and on time. Enjoy hassle-free delivery for all your furniture needs.
                </p>
            </div>
            <!-- Customization Service -->
            <div class="col-md-4 text-center mb-4">
                <i class="bi bi-paint-bucket" style="font-size: 2rem; color: #29AB87;"></i>
                <h4 class="mt-3">Furniture Customization</h4>
                <p>
                    Looking for something unique? Our team offers customization services to bring your dream furniture to life.
                </p>
            </div>
            <!-- Customer Support -->
            <div class="col-md-4 text-center mb-4">
                <i class="bi bi-telephone" style="font-size: 2rem; color: #29AB87;"></i>
                <h4 class="mt-3">24/7 Customer Support</h4>
                <p>
                    Our friendly customer support team is available around the clock to assist you with any inquiries or concerns.
                </p>
            </div>
        </div>
    </div>

    <!-- Our Team -->
    <h2 class="text-center mb-4">Meet Our Team</h2>
    <div class="row team mb-5">
        <div class="col-md-4 text-center">
            <img src="img/Jaber.jpeg" alt="Team Member 1" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
            <h5 class="mt-3">Elizabeth Ojuki</h5>
            <p>Founder & CEO</p>
        </div>
        <div class="col-md-4 text-center">
            <img src="img/shim.jpeg" alt="Team Member 2" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
            <h5 class="mt-3">Shim Chelsea</h5>
            <p>Head of Design</p>
        </div>
        <div class="col-md-4 text-center">
            <img src="img/rose.jpeg" alt="Team Member 3" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
            <h5 class="mt-3">Roselyne Wangechi</h5>
            <p>Operations Manager</p>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>

<!-- Custom CSS -->
<style>
    .about-content, .services, .team {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 30px 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    h1, h2, h3 {
        color: #29AB87;
    }

    .bi {
        margin-bottom: 10px;
    }

    .team img {
        border: 5px solid #29AB87;
    }
</style>
