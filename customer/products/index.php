<?php
 // Define your base folder relative to document root (adjust if needed)
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/header.php';
?>
<?php
 

// Fetch products
$sql = "SELECT * FROM products WHERE is_available = 1 ";
$result = mysqli_query($conn, $sql);
?>

<div class="container mt-5">
    <h2 class="mb-4">Our Products</h2>
    <div class="row">
        <?php while($product = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-3">
                <div class="card mb-4 shadow-sm">
                    <?php if (!empty($product['image'])): ?>
                        <img src="../../uploads/<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                    <?php else: ?>
                        <img src="../assets/no-image.png" class="card-img-top" alt="No Image">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= $product['name'] ?></h5>
                        <p class="card-text">Price: Rs. <?= $product['price'] ?></p>
                        <form action="../cart/add.php" method="POST">
                            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                            <div class="input-group mb-2">
                                <input type="number" name="quantity" class="form-control" value="1" min="1">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

 