<?php
// Define base folder
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Start session and include DB connection and header
session_start();
require_once $projectRoot . '/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // 1. Try logging in as an Admin
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $adminResult = $stmt->get_result();

    if ($admin = $adminResult->fetch_assoc()) {
        if (password_verify($password, $admin['password'])) {
            $_SESSION['user_id'] = $admin['user_id'];
            $_SESSION['username'] = $admin['full_name'];
            $_SESSION['role'] = $admin['role']; // Optional
            header("Location: index.php"); // Redirect to admin panel
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        // 2. Try logging in as a Customer
        $stmt = $conn->prepare("SELECT * FROM customers WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $customerResult = $stmt->get_result();

        if ($customer = $customerResult->fetch_assoc()) {
            if (password_verify($password, $customer['password'])) {
                 $_SESSION['role'] = "Customer";
                $_SESSION['customer_id'] = $customer['customer_id'];
                $_SESSION['username'] = $customer['full_name'];
                header("Location: index.php"); // Redirect to customer page
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "No user found with that username.";
        }
    }
}
?>

<!-- Login Form UI -->
<div class="container mt-5" style="max-width: 500px;">
    <h2 class="mb-4">Login</h2>
    <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST" action="">
        <div class="form-group mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Login</button>
    </form>
</div>
