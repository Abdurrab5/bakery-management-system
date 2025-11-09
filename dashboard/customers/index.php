<?php
$page_title = "Customer Management";

// Define your base folder
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header
require_once $projectRoot . '/header.php';

// Fetch customers
$result = $conn->query("SELECT * FROM customers ORDER BY created_at DESC");
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Customers Management</h2>
        <a href="add.php" class="btn btn-primary">+ Add New Customer</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Loyalty Points</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['customer_id'] ?></td>
                        <td><?= htmlspecialchars($row['full_name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['address']) ?></td>
                        <td><?= $row['loyalty_points'] ?></td>
                        <td><?= $row['created_at'] ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['customer_id'] ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                            <a href="delete.php?id=<?= $row['customer_id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this customer?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
