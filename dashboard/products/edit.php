<?php
// Define your base folder relative to document root (adjust if needed)
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/header.php';

if (!isset($_GET['id'])) {
    die("Missing product ID.");
}
$id = intval($_GET['id']);

// Fetch product
$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $is_available = isset($_POST['is_available']) ? 1 : 0;

    $imageName = $product['image'];
    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetPath = '../../uploads/' . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
    }

    // Update product
    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, category = ?, price = ?, image = ?, is_available = ? WHERE product_id = ?");
    $stmt->bind_param("sssdsii", $name, $desc, $category, $price, $imageName, $is_available, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<div class="container mt-4">
    <h2>Edit Product</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($product['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Category</label>
            <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($product['category']) ?>">
        </div>
        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control" step="0.01" value="<?= $product['price'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Current Image</label><br>
            <?php if ($product['image']) : ?>
                <img src="../../uploads/<?= htmlspecialchars($product['image']) ?>" width="120" class="mb-2">
            <?php endif; ?>
            <input type="file" name="image" class="form-control">
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="is_available" class="form-check-input" <?= $product['is_available'] ? 'checked' : '' ?>>
            <label class="form-check-label">Available</label>
        </div>
        <button type="submit" class="btn btn-success">Update Product</button>
    </form>
</div>
