<?php
// redirect_if_not_logged_in();
$page_title = "Notification Management";
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;
require_once $projectRoot . '/header.php';

$result = $conn->query("SELECT * FROM notifications ORDER BY sent_at DESC");
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Notifications Management</h2>
        <a href="add.php" class="btn btn-primary">+ Add Notification</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Customer ID</th>
                    <th>Message</th>
                    <th>Type</th>
                    <th>Sent At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['notification_id'] ?></td>
                    <td><?= $row['customer_id'] ?></td>
                    <td><?= htmlspecialchars($row['message']) ?></td>
                    <td><span class="badge bg-info text-dark"><?= $row['type'] ?></span></td>
                    <td><?= date("Y-m-d H:i", strtotime($row['sent_at'])) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row['notification_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete.php?id=<?= $row['notification_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this notification?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
