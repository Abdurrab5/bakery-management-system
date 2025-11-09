<?php
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;
require_once $projectRoot . '/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $loyalty_points = $_POST['loyalty_points'] ?? 0;
    $is_active = 1;
    $last_login = NULL;

    $stmt = $conn->prepare("INSERT INTO customers (full_name, username, email, password, phone, address, loyalty_points, is_active, last_login, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssssssiiis", $full_name, $username, $email, $password, $phone, $address, $loyalty_points, $is_active, $last_login);
    
    if ($stmt->execute()) {
        header("Location: index.php?added=1");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
}
?>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Register New Customer</h4>
        </div>
        <div class="card-body">
            <form method="POST" class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Loyalty Points</label>
                    <input type="number" name="loyalty_points" class="form-control" value="0">
                </div>

                <div class="col-12">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="2"></textarea>
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-success">Register Customer</button>
                </div>
            </form>
        </div>
    </div>
</div>
