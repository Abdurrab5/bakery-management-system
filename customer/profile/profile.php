<?php
 // Define your base folder relative to document root (adjust if needed)
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/header.php';
?><?php
 

// Redirect to login if not logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: ../../login.php");
    exit;
}

// Include database connection
 

$customer_id = $_SESSION['customer_id'];

// Fetch user data
$sql = "SELECT * FROM customers WHERE customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

if (!$customer) {
    echo "Customer not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Profile</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Your Profile</h2>
    <table class="table table-bordered">
        <tr>
            <th>Full Name</th>
            <td><?= htmlspecialchars($customer['full_name']) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= htmlspecialchars($customer['email']) ?></td>
        </tr>
        <tr>
            <th>Phone</th>
            <td><?= htmlspecialchars($customer['phone']) ?></td>
        </tr>
        <tr>
            <th>Address</th>
            <td><?= nl2br(htmlspecialchars($customer['address'])) ?></td>
        </tr>
        <tr>
            <th>Joined On</th>
            <td><?= $customer['created_at'] ?></td>
        </tr>
    </table>

    <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
    <a href="../orders/index.php" class="btn btn-secondary">My Orders</a>
    <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
</div>
</body>
</html>
