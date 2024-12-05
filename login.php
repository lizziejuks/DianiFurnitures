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

    try {
        // Fetch user data from the database
        $stmt = $pdo->prepare("SELECT user_id, email, password, role FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists and password is correct
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Redirect to the dashboard page based on user role
            if ($user['role'] == 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: products.php");
            }
            exit();
        } else {
            $error_message = "Invalid email or password.";
        }
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
            overflow: hidden;
        }
        .container {
            width: 350px;
            height: 500px;
            border-radius: 20px;
            padding: 40px;
            background: rgba(236, 240, 243, 0.95); /* Slight transparency */
            box-shadow: 14px 14px 20px #cbced1, -14px -14px 20px white;
        }
        .brand-logo {
            height: 100px;
            width: 100px;
            background: url("img/logo.png") center/cover;
            margin: auto;
            border-radius: 50%;
            box-shadow: 7px 7px 10px #cbced1, -7px -7px 10px white;
        }
        .brand-title {
            margin-top: 10px;
            font-weight: 900;
            font-size: 1.8rem;
            color: #1DA1F2;
            letter-spacing: 1px;
            text-align: center;
        }
        .inputs {
            text-align: left;
            margin-top: 30px;
        }
        label {
            display: block;
            margin-bottom: 4px;
        }
        input {
            width: 100%;
            background: #ecf0f3;
            padding: 10px 20px;
            height: 50px;
            font-size: 14px;
            border-radius: 50px;
            box-shadow: inset 6px 6px 6px #cbced1, inset -6px -6px 6px white;
            border: none;
            outline: none;
            margin-bottom: 12px;
        }
        input::placeholder {
            color: gray;
        }
        button {
            width: 100%;
            color: white;
            margin-top: 20px;
            background: #1DA1F2;
            height: 40px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 900;
            box-shadow: 6px 6px 6px #cbced1, -6px -6px 6px white;
            transition: 0.5s;
            border: none;
            outline: none;
        }
        button:hover {
            box-shadow: none;
        }
        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
            margin: 10px 0;
        }
        .register-link {
            text-align: center; /* Center the link */
            margin-top: 20px; /* Space above the link */
            display: block; /* Block display for link */
            color: #1DA1F2; /* Link color */
            text-decoration: none; /* Remove underline */
        }
        .register-link:hover {
            text-decoration: underline; /* Underline on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="brand-logo"></div>
        <div class="brand-title">LOGIN</div>
        <?php if (isset($error_message)): ?>
            <p class="error-message"><?= $error_message ?></p>
        <?php endif; ?>
        <div class="inputs">
            <form method="POST" action="login.php">
                <label for="email">EMAIL</label>
                <input type="email" id="email" name="email" placeholder="example@test.com" required>
                
                <label for="password">PASSWORD</label>
                <input type="password" id="password" name="password" placeholder="Enter Password" required>
                
                <button type="submit">LOGIN</button>
            </form>
            <a href="register.php" class="register-link">Don't have an account? Register here</a> <!-- Registration link -->
        </div>
    </div>
</body>
</html>
