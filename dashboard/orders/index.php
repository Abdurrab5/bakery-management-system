<?php
// Define your base folder relative to document root (adjust if needed)
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/header.php';

$result = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");
?>

<div class="container mt-4">
   <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Orders Management</h2>
        <a href="add.php" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Add New Order
        </a>
    </div> <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer ID</th>
                <th>Order Date</th>
                <th>Delivery Date</th>
                <th>Status</th>
                <th>Total</th>
                 <th>Update</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['order_id'] ?></td>
                <td><?= $row['customer_id'] ?></td>
                <td><?= $row['order_date'] ?></td>
                <td><?= $row['delivery_date'] ?></td>
                <td><?= $row['status'] ?></td>
                <td><?= $row['total_amount'] ?></td>
                <td>
    <form method="post" action="update_status.php" class="d-flex">
        <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
        <select name="status" class="form-select form-select-sm me-2">
            <option value="Pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="Processing" <?= $row['status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
            <option value="Ready" <?= $row['status'] == 'ready' ? 'selected' : '' ?>>Ready</option>
            <option value="Delivered" <?= $row['status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
            <option value="Cancelled" <?= $row['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
        </select>
        <button type="submit" class="btn btn-sm btn-success">Update</button>
    </form>
</td>

                <td>
                    <a href="edit.php?id=<?= $row['order_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete.php?id=<?= $row['order_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
