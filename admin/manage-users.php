<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../includes/db.php'); // Include database connection

// Add User Form Processing
if (isset($_POST['add_user'])) {
    try {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'] ?? 'customer';

        // Insert new user into the database
        $query = "INSERT INTO users (first_name, last_name, email, username, password, role) VALUES (:first_name, :last_name, :email, :username, :password, :role)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->execute();

        // Success message
        $success_message = "User added successfully!";
    } catch (PDOException $e) {
        // Error message
        $error_message = "Error adding user: " . $e->getMessage();
    }
}



// Delete User Processing
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Delete the user from the database
    $query = "DELETE FROM users WHERE user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $delete_id, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect back to the same page to see the changes
    header("Location: manage-users.php");
    exit();
}
?>

<div class="container-fluid">
    <h2 class="mt-4">Manage Users</h2>

    <!-- Success/Error Message -->
    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($success_message); ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php endif; ?>

    <!-- Add User Form -->
    <div class="mb-4">
        <h4>Add New User</h4>
        <form action="manage-users.php" method="POST">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" name="first_name" required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="last_name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" name="role">
                    <option value="customer">Customer</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
        </form>
    </div>

    <!-- Users Table -->
    <h4>Existing Users</h4>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch and display users
                    $query = "SELECT user_id, first_name, last_name, email, role FROM users";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $users = $stmt->fetchAll();

                    foreach ($users as $user) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($user['user_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['role']) . "</td>";
                        echo "<td>
                                <a href='manage-users.php?delete_id=" . $user['user_id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
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
