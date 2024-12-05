<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection
require_once 'includes/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $username = htmlspecialchars(trim($_POST['username']));
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $phone_number = htmlspecialchars(trim($_POST['phone_number']));
    $address = htmlspecialchars(trim($_POST['address']));

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        // Hash the password
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        try {
            // Check if email is already registered
            $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $existing_user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existing_user) {
                $error_message = "Email is already registered.";
            } else {
                // Insert user into database
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, first_name, last_name, phone_number, address, role) VALUES (:username, :email, :password_hash, :first_name, :last_name, :phone_number, :address, 'customer')");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password_hash', $password_hash);
                $stmt->bindParam(':first_name', $first_name);
                $stmt->bindParam(':last_name', $last_name);
                $stmt->bindParam(':phone_number', $phone_number);
                $stmt->bindParam(':address', $address);
                $stmt->execute();

                // Redirect to login page
                header("Location: login.php");
                exit();
            }
        } catch (PDOException $e) {
            $error_message = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;900&display=swap">
    <style>
     body {
    margin: 0;
    width: 100vw;
    height: 100vh;
    background: url('img/back2.jpg') no-repeat center center fixed;
    background-size: cover;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Poppins', sans-serif;
}

.container {
    width: 90%; /* Adjusted to fit smaller screens */
    max-width: 400px; /* Added max-width for larger screens */
    border-radius: 20px;
    padding: 20px 30px; /* Reduced padding for better fit */
    background: rgba(236, 240, 243, 0.95); /* Slight transparency */
    box-shadow: 14px 14px 20px #cbced1, -14px -14px 20px white;
}

.brand-logo {
    height: 80px; /* Reduced size for better fit */
    width: 80px;
    background: url("img/logo.png") center/cover;
    margin: auto;
    border-radius: 50%;
    box-shadow: 7px 7px 10px #cbced1, -7px -7px 10px white;
}

.brand-title {
    margin-top: 10px;
    font-weight: 900;
    font-size: 1.6rem; /* Slightly reduced font size */
    color: #1DA1F2;
    letter-spacing: 1px;
    text-align: center;
}

.inputs {
    text-align: left;
    margin-top: 20px; /* Reduced margin */
}

label {
    display: block;
    margin-bottom: 4px;
    font-size: 14px; /* Smaller font for labels */
    color: #333;
}

input {
    width: 100%;
    background: #ecf0f3;
    padding: 8px 15px; /* Reduced padding */
    height: 40px; /* Reduced height */
    font-size: 13px; /* Smaller font size for inputs */
    border-radius: 50px;
    box-shadow: inset 4px 4px 6px #cbced1, inset -4px -4px 6px white; /* Adjusted shadow for consistency */
    border: none;
    outline: none;
    margin-bottom: 10px; /* Reduced margin */
}

input::placeholder {
    color: gray;
    font-size: 12px; /* Slightly smaller placeholder text */
}

button {
    width: 100%;
    color: white;
    margin-top: 15px; /* Reduced top margin */
    background: #1DA1F2;
    height: 40px;
    border-radius: 20px;
    cursor: pointer;
    font-weight: 900;
    box-shadow: 6px 6px 6px #cbced1, -6px -6px 6px white;
    transition: 0.3s; /* Faster transition */
    border: none;
    outline: none;
    font-size: 14px; /* Slightly smaller font size */
}

button:hover {
    box-shadow: none;
    background: #0c85d0; /* Slightly darker hover color */
}

.error-message {
    color: red;
    font-size: 13px; /* Smaller font size for error messages */
    text-align: center;
    margin: 10px 0;
}

.login-link {
    text-align: center;
    margin-top: 15px; /* Reduced top margin */
    display: block;
    color: #1DA1F2;
    font-size: 14px; /* Smaller font size */
    text-decoration: none;
}

.login-link:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="brand-logo"></div>
        <div class="brand-title">REGISTER</div>
        <?php if (isset($error_message)): ?>
            <p class="error-message"><?= $error_message ?></p>
        <?php endif; ?>
        <div class="inputs">
            <form method="POST" action="register.php">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter Username" required>
                
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" placeholder="Enter First Name" required>
                
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" placeholder="Enter Last Name" required>
                
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Email" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Password" required>
                
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" placeholder="Enter Phone Number" required>
                
                <label for="address">Address</label>
                <input type="text" id="address" name="address" placeholder="Enter Address">
                
                <button type="submit">Register</button>
            </form>
            <a href="login.php" class="login-link">Already have an account? Login here</a>
        </div>
    </div>
</body>
</html>
