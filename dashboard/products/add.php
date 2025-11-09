<?php
// Define your base folder relative to document root (adjust if needed)
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $is_available = isset($_POST['is_available']) ? 1 : 0;

    // Handle image upload
    $imageName = '';
    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetPath = '../../uploads/' . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);
    }

    // Prepare MySQLi statement
    $stmt = $conn->prepare("INSERT INTO products (name, description, category, price, image, is_available) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $name, $desc, $category, $price, $imageName, $is_available);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
<div class="container mt-5">
    <h2>Add New Product</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group mb-3">
            <label for="name">Product Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="form-group mb-3">
            <label for="category">Category</label>
            <input type="text" name="category" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="price">Price (PKR)</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="image">Product Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_available" class="form-check-input" id="is_available">
            <label class="form-check-label" for="is_available">Available</label>
        </div>

        <button type="submit" class="btn btn-success">Add Product</button>
    </form>
</div>
