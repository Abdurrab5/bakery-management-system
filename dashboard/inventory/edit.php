<?php
// Define your base folder relative to document root (adjust if needed)
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/header.php';
$id = $_GET['id'];
$item = $conn->query("SELECT * FROM inventory WHERE inventory_id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = $_POST['item_name'];
    $unit = $_POST['unit'];
    $quantity = $_POST['quantity'];
    $min_required = $_POST['min_required'];

    $stmt = $conn->prepare("UPDATE inventory SET item_name=?, unit=?, quantity=?, min_required=?, updated_at=NOW() WHERE inventory_id=?");
    $stmt->bind_param("ssiii", $item_name, $unit, $quantity, $min_required, $id);
    $stmt->execute();

    header("Location: index.php");
}
?>

<!-- HTML form for editing -->
<div class="container mt-5">
    <div class="card shadow rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
            <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Inventory Item</h4>
            <a href="inventory_list.php" class="btn btn-light btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
        </div>
        <div class="card-body">
            <form method="post" class="row g-3">
                <div class="col-md-6">
                    <label for="item_name" class="form-label">Item Name</label>
                    <input type="text" id="item_name" name="item_name" class="form-control" value="<?= htmlspecialchars($item['item_name']) ?>" required>
                </div>

                <div class="col-md-6">
                    <label for="unit" class="form-label">Unit (e.g. pcs, kg)</label>
                    <input type="text" id="unit" name="unit" class="form-control" value="<?= htmlspecialchars($item['unit']) ?>" required>
                </div>

                <div class="col-md-6">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" value="<?= $item['quantity'] ?>" required>
                </div>

                <div class="col-md-6">
                    <label for="min_required" class="form-label">Minimum Required</label>
                    <input type="number" id="min_required" name="min_required" class="form-control" value="<?= $item['min_required'] ?>" required>
                </div>

                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-success btn-lg px-4">
                        <i class="bi bi-save me-2"></i>Update Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
