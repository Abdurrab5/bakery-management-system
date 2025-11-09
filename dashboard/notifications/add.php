<?php
// redirect_if_not_logged_in();
$page_title = "Notification Management";

// Define your base folder relative to document root
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header
require_once $projectRoot . '/header.php';

// Fetch customers for dropdown
$customers = $conn->query("SELECT customer_id, full_name FROM customers ORDER BY full_name ASC");
?>

<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add Notification</h4>
        </div>
        <div class="card-body">
            <form method="post" action="process.php">
                <input type="hidden" name="action" value="add">

                <div class="mb-3">
                    <label for="customer_id" class="form-label">Select Customer</label>
                    <select class="form-select" id="customer_id" name="customer_id" required>
                        <option value="" disabled selected>-- Select Customer --</option>
                        <?php while ($row = $customers->fetch_assoc()): ?>
                            <option value="<?= $row['customer_id'] ?>"><?= htmlspecialchars($row['full_name']) ?> (ID: <?= $row['customer_id'] ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Notification Type</label>
                    <select class="form-select" id="type" name="type" required>
                        <option value="" disabled selected>-- Select Type --</option>
                        <option value="Order">Order</option>
                        <option value="Promo">Promo</option>
                        <option value="System">System</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-success">Save Notification</button>
                </div>
            </form>
        </div>
    </div>
</div>
