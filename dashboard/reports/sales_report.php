<?php
// redirect_if_not_logged_in();
$page_title = "Sales Reports";
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;
require_once $projectRoot . '/includes/db_connect.php';

$date = $_GET['date'] ?? date('Y-m-d');
$searchCustomer = $_GET['customer'] ?? '';

$sql = "SELECT o.order_id, o.order_date, c.full_name, o.total_amount 
        FROM orders o 
        JOIN customers c ON o.customer_id = c.customer_id 
        WHERE DATE(order_date) = ?";

if (!empty($searchCustomer)) {
    $sql .= " AND c.full_name LIKE ?";
}

$stmt = $conn->prepare($sql);

if (!empty($searchCustomer)) {
    $like = '%' . $searchCustomer . '%';
    $stmt->bind_param('ss', $date, $like);
} else {
    $stmt->bind_param('s', $date);
}

$stmt->execute();
$result = $stmt->get_result();
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-4">
    <h2 class="mb-4">📊 Sales Report</h2>

    <!-- Filter Form -->
    <form method="get" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="date" class="form-label">Select Date</label>
            <input type="date" class="form-control" name="date" id="date" value="<?= htmlspecialchars($date) ?>">
        </div>
        <div class="col-md-4">
            <label for="customer" class="form-label">Search by Customer</label>
            <input type="text" class="form-control" name="customer" id="customer" value="<?= htmlspecialchars($searchCustomer) ?>" placeholder="Customer Name">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">🔍 Filter</button>
            <a href="sales_reports.php" class="btn btn-secondary ms-2">Reset</a>
        </div>
    </form>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['order_id'] ?></td>
                            <td><?= $row['full_name'] ?></td>
                            <td><?= $row['order_date'] ?></td>
                            <td>Rs <?= number_format($row['total_amount'], 2) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">No sales found for this criteria.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
 
