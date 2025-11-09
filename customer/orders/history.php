<?php
 // Define your base folder relative to document root (adjust if needed)
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/header.php';
?>

<?php
 

if (!isset($_SESSION['customer_id']) || !isset($_GET['id'])) {
    die("Access denied");
}

$order_id = $_GET['id'];
$customer_id = $_SESSION['customer_id'];

// Fetch order
$order_query = "SELECT * FROM orders WHERE order_id = $order_id AND customer_id = $customer_id";
$order_result = mysqli_query($conn, $order_query);
$order = mysqli_fetch_assoc($order_result);

if (!$order) {
    die("Order not found.");
}

// Fetch items
$items_query = "
    SELECT oi.*, p.name 
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    WHERE oi.order_id = $order_id
";
$items_result = mysqli_query($conn, $items_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice #<?= $order_id ?></title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Invoice #<?= $order_id ?></h2>
    <p><strong>Date:</strong> <?= $order['created_at'] ?></p>
    <p><strong>Status:</strong> <?= $order['status'] ?></p>
    <hr>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; ?>
            <?php while ($item = mysqli_fetch_assoc($items_result)): ?>
                <?php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; ?>
                <tr>
                    <td><?= $item['name'] ?></td>
                    <td>Rs. <?= $item['price'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>Rs. <?= $subtotal ?></td>
                </tr>
            <?php endwhile; ?>
            <tr class="fw-bold table-info">
                <td colspan="3" class="text-end">Total</td>
                <td>Rs. <?= $total ?></td>
            </tr>
        </tbody>
    </table>

    <a href="javascript:window.print()" class="btn btn-primary">Print Invoice</a>
</div>
</body>
</html>
