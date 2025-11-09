<?php
// redirect_if_not_logged_in();
$page_title = "Edit Notification";
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;
require_once $projectRoot . '/header.php';

// Database query
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM notifications WHERE notification_id=$id");
$row = $result->fetch_assoc();
?>

<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Edit Notification</h4>
        </div>
        <div class="card-body">
            <form method="post" action="process.php">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="notification_id" value="<?= $row['notification_id'] ?>">

                <div class="mb-3">
                    <label for="customer_id" class="form-label">Customer ID</label>
                    <input type="number" class="form-control" id="customer_id" name="customer_id" value="<?= $row['customer_id'] ?>" required>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="4" required><?= $row['message'] ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Notification Type</label>
                    <select class="form-select" id="type" name="type" required>
                        <option value="order" <?= $row['type'] === 'order' ? 'selected' : '' ?>>Order</option>
                        <option value="promo" <?= $row['type'] === 'promo' ? 'selected' : '' ?>>Promo</option>
                        <option value="system" <?= $row['type'] === 'system' ? 'selected' : '' ?>>System</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Update Notification</button>
                </div>
            </form>
        </div>
    </div>
</div>
