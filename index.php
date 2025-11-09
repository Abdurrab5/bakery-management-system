<?php
session_start();
$role = $_SESSION['role'] ?? 'Guest';
$customer_id = $_SESSION['user_id'] ?? 0;

$page_title = "Welcome to Bakery";
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

require_once $projectRoot . '/header.php';

// Fetch all products
$sql = "SELECT product_id, name, description, category, price, image, is_available FROM products WHERE is_available = 1 ORDER BY name ASC";
$result = $conn->query($sql);
?>

<div class="container mt-5">
  <h2 class="text-center mb-4">Our Products</h2>

  <?php if ($result->num_rows > 0): ?>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col">
          <div class="card h-100 shadow-sm border-0">
            <?php if (!empty($row['image'])): ?>
              <img src="uploads/<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['name']) ?>" style="height: 180px; object-fit: cover;">
            <?php else: ?>
              <img src="/bakery/assets/no-image.png" class="card-img-top" alt="No image" style="height: 180px; object-fit: cover;">
            <?php endif; ?>

            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
              <p class="card-text mb-1 text-muted"><?= htmlspecialchars($row['description']) ?></p>
              <p class="card-text mb-2">Category: <?= htmlspecialchars($row['category']) ?></p>
              <p class="card-text mb-3">Price: <strong>Rs <?= number_format($row['price']) ?></strong></p>

              <?php if ($role === "Customer"): ?>
                <form method="POST" action="customer/cart/add.php" class="mt-auto">
                  <input type="hidden" name="action" value="place_order">
                  <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                  <input type="hidden" name="customer_id" value="<?= $customer_id ?>">
                  <input type="number" name="quantity" min="1" required class="form-control mb-2" placeholder="Enter quantity">
                  <button type="submit" class="btn btn-primary w-100">Order Now</button>
                </form>
              <?php else: ?>
                <p class="text-info mt-auto">Login as Customer to order</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">No products available at the moment.</div>
  <?php endif; ?>
</div>

 
