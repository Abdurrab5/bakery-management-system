<?php
 // Define your base folder relative to document root (adjust if needed)
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/header.php';
?>
<?php
 

if (!isset($_SESSION['customer_id'])) {
    header('Location: ../../login.php');
    exit();
}

$customer_id = $_SESSION['customer_id'];
$query = "SELECT * FROM orders WHERE customer_id = $customer_id ORDER BY order_id DESC";
$result = mysqli_query($conn, $query);
?>

<div class="container mt-5">
    <h3>My Orders</h3>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Order placed successfully!</div>
    <?php endif; ?>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Total</th>
                <th>Status</th>
                <th>Invoice</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($order = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $order['order_id'] ?></td>
                    <td>Rs. <?= $order['total_amount'] ?></td>
                    <td><?= $order['status'] ?></td>
                    <td>
                        <a href="../invoice/history.php?id=<?= $order['order_id'] ?>" class="btn btn-sm btn-outline-primary">View</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

 
