<?php
$page_title = "Employee Salary Report";
$baseURL = '/bakery'; // change if needed
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;
require_once $projectRoot . '/includes/db_connect.php';

// Get employee data
$sql = "SELECT employee_id, name, role, phone, email, salary, shift_time, status, created_at FROM employees ORDER BY name ASC";
$result = $conn->query($sql);
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Employee Salary Report</h4>
        </div>
        <div class="card-body">
            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Shift Time</th>
                                <th>Salary (Monthly)</th>
                                <th>Status</th>
                                <th>Hired On</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['role']) ?></td>
                                <td><?= htmlspecialchars($row['phone']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['shift_time']) ?></td>
                                <td>Rs. <?= number_format($row['salary'], 2) ?></td>
                                <td>
                                    <?php if ($row['status'] == 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('Y-m-d', strtotime($row['created_at'])) ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">No employees found.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
