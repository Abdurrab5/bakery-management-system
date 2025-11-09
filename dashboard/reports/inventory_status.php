<?php
// redirect_if_not_logged_in();
$page_title = "Inventory Status";
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

require_once $projectRoot . '/includes/db_connect.php';

// Fetch inventory data
$result = $conn->query("SELECT * FROM inventory ORDER BY item_name");
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Inventory Status</h4>
        </div>
        <div class="card-body">
            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                                <th>Minimum Required</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr class="<?= $row['quantity'] < $row['min_required'] ? 'table-danger' : 'table-success' ?>">
                                    <td><?= htmlspecialchars($row['item_name']) ?></td>
                                    <td><?= htmlspecialchars($row['unit']) ?></td>
                                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                                    <td><?= htmlspecialchars($row['min_required']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">No inventory items found.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
