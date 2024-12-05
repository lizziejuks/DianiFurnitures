<?php
include('admin-header.php');
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 sidebar py-4">
            <h5 class="text-center">Admin Menu</h5>
            <ul class="nav flex-column">
                <!-- Products Section -->
                <li class="nav-item">
    <a class="nav-link load-content" data-target="manage_products.php" href="#">
        <i class="bi bi-box-seam"></i> Products
    </a>
</li>

                <!-- Users Section -->
                <li class="nav-item">
                    <a class="nav-link" href="#usersSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="bi bi-people"></i> Users
                    </a>
                    <ul class="collapse" id="usersSubmenu">
                        <li><a class="nav-link ps-4 load-content" data-target="manage-users.php" href="#">Manage Users</a></li>
                    </ul>
                </li>
                <!-- Orders Section -->
                <li class="nav-item">
                    <a class="nav-link" href="#ordersSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="bi bi-cart-check"></i> Orders
                    </a>
                    <ul class="collapse" id="ordersSubmenu">
                        <li><a class="nav-link ps-4 load-content" data-target="manage_orders.php" href="#">Manage Orders</a></li>
                    </ul>
                </li>
                <!-- Settings -->
                <li class="nav-item">
                    <a class="nav-link load-content" data-target="settings.php" href="#">Settings</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-10 p-4" id="main-content">
            <h2>Dashboard</h2>
            <div class="row">
                <!-- Statistic Cards -->
                <div class="col-md-3">
                    <div class="stat-card bg-primary text-center">
                        <i class="bi bi-truck"></i>
                        <h3>45</h3>
                        <p>Deliveries</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card bg-success text-center">
                        <i class="bi bi-people"></i>
                        <h3>120</h3>
                        <p>Users</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card bg-warning text-center">
                        <i class="bi bi-cart"></i>
                        <h3>75</h3>
                        <p>Orders</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card bg-danger text-center">
                        <i class="bi bi-box-seam"></i>
                        <h3>50</h3>
                        <p>Products</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Load content dynamically when sidebar links are clicked
    $(document).on('click', '.load-content', function (e) {
        e.preventDefault(); // Prevent default link behavior

        // Get the target file path from the data-target attribute
        const target = $(this).data('target');

        // Show a loading message while the content is being fetched
        $('#main-content').html('<div class="text-center"><i class="bi bi-arrow-repeat spinning"></i> Loading...</div>');

        // Load the content dynamically into the main content section
        $('#main-content').load(target, function(response, status, xhr) {
            if (status == "error") {
                // In case of error, show the error in the main content
                $('#main-content').html('<div class="text-center text-danger">Error: Could not load the content.</div>');
                console.log("Error loading the content: " + xhr.status + " " + xhr.statusText);
            }
        });
    });

    // Make sure that the active class is handled correctly for collapsing menus
    $(document).on('click', '.nav-link', function () {
        // Remove the active class from all other links and add it to the clicked one
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
    });
</script>

</body>
</html>
