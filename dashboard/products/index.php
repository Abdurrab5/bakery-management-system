<?php
 
// redirect_if_not_logged_in(); // Uncomment if login system is ready
$page_title = "Products Management";
// Define your base folder relative to document root (adjust if needed)
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/header.php';
// Fetch products from database
$sql = "SELECT product_id, name, description, category, price, image, is_available, created_at FROM products ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Products</h2>
        <a href="add.php" class="btn btn-success">Add New Product</a>
    </div>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price (PKR)</th>
                <th>Image</th>
                <th>Available</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['product_id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['category']) ?></td>
                    <td><?= number_format($row['price'], 2) ?></td>
                    <td>
                        <?php if (!empty($row['image'])): ?>
                            <img src="../../uploads/<?= htmlspecialchars($row['image']) ?>" alt="Image" width="60" height="60">
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= $row['is_available'] ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>' ?>
                    </td>
                    <td><?= date("d M, Y", strtotime($row['created_at'])) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['product_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete.php?id=<?= $row['product_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

 
