<?php
// Start session and include DB connection
 
 // Define your base folder relative to document root (adjust if needed)
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/header.php';
 
// Validate order ID from GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid order ID.');
}

$order_id = intval($_GET['id']);

// Fetch order details
$order_sql = "SELECT o.*, c.full_name, c.email, c.phone, c.address 
              FROM orders o 
              JOIN customers c ON o.customer_id = c.customer_id 
              WHERE o.order_id = ?";
$stmt = $conn->prepare($order_sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();
$order = $order_result->fetch_assoc();

if (!$order) {
    die('Order not found.');
}
$stmt->close();

// Fetch order items
$item_sql = "SELECT oi.*, p.name 
             FROM order_items oi 
             JOIN products p ON oi.product_id = p.product_id 
             WHERE oi.order_id = ?";
$stmt = $conn->prepare($item_sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$items_result = $stmt->get_result();

$items = [];
while ($row = $items_result->fetch_assoc()) {
    $items[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice #<?= $order_id ?></title>
    <link rel="stylesheet" href="../../assets/bootstrap.min.css">
    <style>
        .invoice-box {
            padding: 30px;
            max-width: 800px;
            margin: auto;
            border: 1px solid #eee;
            background: #fff;
        }
    </style>
</head>
<body>
<div class="invoice-box">
    <h2>Invoice #<?= $order_id ?></h2>
 

    <h5>Customer Info</h5>
    <p>
        <strong>Name:</strong> <?= htmlspecialchars($order['full_name']) ?><br>
        <strong>Email:</strong> <?= htmlspecialchars($order['email']) ?><br>
        <strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?><br>
        <strong>Address:</strong> <?= nl2br(htmlspecialchars($order['address'])) ?>
    </p>

    <h5>Order Items</h5>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $grandTotal = 0;
        foreach ($items as $index => $item):
            $total = $item['price'] * $item['quantity'];
            $grandTotal += $total;
            ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= number_format($item['price'], 2) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td><?= number_format($total, 2) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="4" class="text-end">Grand Total</th>
            <th><?= number_format($grandTotal, 2) ?></th>
        </tr>
        </tfoot>
    </table>

    <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>

    <div class="mt-4">
        <button onclick="window.print()" class="btn btn-primary">Print / Download</button>
        <a href="../orders/index.php" class="btn btn-secondary">Back to Orders</a>
    </div>
</div>
</body>
</html>
