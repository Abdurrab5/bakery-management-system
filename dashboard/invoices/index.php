<?php
// redirect_if_not_logged_in();
$page_title = "Invoices Management";

// Define your base folder relative to document root
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically
require_once $projectRoot . '/header.php';

$result = $conn->query("SELECT * FROM invoices");
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Invoices Management</h2>
        <!-- Optional: Add new invoice button -->
        <!-- <a href="add.php" class="btn btn-primary">Add New Invoice</a> -->
    </div>

    <div class="table-responsive shadow rounded">
        <table class="table table-bordered table-hover align-middle bg-white">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Tax</th>
                    <th>Discount</th>
                    <th>Total Due</th>
                    <th>Payment Method</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['invoice_id'] ?></td>
                    <td><?= $row['order_id'] ?></td>
                    <td><?= date("d M Y", strtotime($row['invoice_date'])) ?></td>
                    <td><?= number_format($row['tax'], 2) ?></td>
                    <td><?= number_format($row['discount'], 2) ?></td>
                    <td><strong class="text-success">Rs. <?= number_format($row['total_due'], 2) ?></strong></td>
                    <td><?= htmlspecialchars($row['payment_method']) ?></td>
                    <td>
                         <a href="invoice.php?invoice_id=<?= $row['invoice_id'] ?>" class="btn btn-sm btn-outline-primary">view</a>
                     
                        <a href="edit.php?id=<?= $row['invoice_id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                        <a href="delete.php?id=<?= $row['invoice_id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this invoice?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
