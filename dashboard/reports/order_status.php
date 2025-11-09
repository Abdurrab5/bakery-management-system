<?php
// redirect_if_not_logged_in(); // Uncomment if using login system
$page_title = "Order Status";
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;
require_once $projectRoot . '/includes/db_connect.php';

// Filters
$statusFilter = $_GET['status'] ?? '';
$dateFilter = $_GET['date'] ?? '';

$whereClauses = [];
$params = [];
$types = '';

if ($statusFilter) {
    $whereClauses[] = "o.status = ?";
    $params[] = $statusFilter;
    $types .= 's';
}
if ($dateFilter) {
    $whereClauses[] = "DATE(o.order_date) = ?";
    $params[] = $dateFilter;
    $types .= 's';
}

$whereSQL = $whereClauses ? 'WHERE ' . implode(' AND ', $whereClauses) : '';

$sql = "SELECT o.order_id, o.order_date, o.status, o.total_amount, c.full_name 
        FROM orders o 
        JOIN customers c ON o.customer_id = c.customer_id 
        $whereSQL 
        ORDER BY o.order_date DESC";

$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
    <h2 class="mb-4"><?= $page_title ?></h2>

    <form class="row g-3 mb-4" method="get">
        <div class="col-md-4">
            <label for="status" class="form-label">Order Status</label>
            <select id="status" name="status" class="form-select">
                <option value="">All</option>
                <option value="Pending" <?= $statusFilter === 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Processing" <?= $statusFilter === 'Processing' ? 'selected' : '' ?>>Processing</option>
                <option value="Delivered" <?= $statusFilter === 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                <option value="Cancelled" <?= $statusFilter === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="date" class="form-label">Order Date</label>
            <input type="date" id="date" name="date" class="form-control" value="<?= htmlspecialchars($dateFilter) ?>">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total (Rs)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['order_id'] ?></td>
                            <td><?= htmlspecialchars($row['full_name']) ?></td>
                            <td><?= date('d-M-Y', strtotime($row['order_date'])) ?></td>
                            <td><?= number_format($row['total_amount']) ?></td>
                            <td>
                                <span class="badge 
                                    <?= match ($row['status']) {
                                        'Pending' => 'bg-warning text-dark',
                                        'Processing' => 'bg-info text-dark',
                                        'Delivered' => 'bg-success',
                                        'Cancelled' => 'bg-danger',
                                        default => 'bg-secondary'
                                    } ?>">
                                    <?= $row['status'] ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">No orders found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

 