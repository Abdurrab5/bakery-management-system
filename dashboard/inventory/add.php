<?php
// Define your base folder relative to document root (adjust if needed)
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = $_POST['item_name'];
    $unit = $_POST['unit'];
    $quantity = $_POST['quantity'];
    $min_required = $_POST['min_required'];

    $stmt = $conn->prepare("INSERT INTO inventory (item_name, unit, quantity, min_required) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $item_name, $unit, $quantity, $min_required);
    $stmt->execute();

    header("Location: inventory_list.php");
    exit;
}
?>
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4">
                    <h4 class="mb-0">Add Inventory Item</h4>
                </div>
                <div class="card-body p-4">
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Item Name</label>
                            <input type="text" name="item_name" class="form-control form-control-lg rounded-3" placeholder="Enter item name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Unit (e.g. pcs, kg)</label>
                            <input type="text" name="unit" class="form-control form-control-lg rounded-3" placeholder="Enter unit type" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control form-control-lg rounded-3" placeholder="Enter quantity" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Minimum Required</label>
                            <input type="number" name="min_required" class="form-control form-control-lg rounded-3" placeholder="Enter minimum required quantity" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill">
                                <i class="bi bi-plus-circle me-2"></i> Save Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
