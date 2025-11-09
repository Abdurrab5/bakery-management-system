<?php
 // Define your base folder relative to document root (adjust if needed)
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/header.php';
?>
<?php
 

// Fetch cart from session
$cart = $_SESSION['cart'] ?? [];

$products = [];
$total = 0;

if (!empty($cart)) {
    $ids = implode(',', array_keys($cart));
    $query = "SELECT * FROM products WHERE product_id IN ($ids)";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $row['quantity'] = $cart[$row['product_id']];
        $row['subtotal'] = $row['price'] * $row['quantity'];
        $total += $row['subtotal'];
        $products[] = $row;
    }
}
?>

<div class="container mt-5">
    <h2 class="mb-4">Your Cart</h2>

    <?php if (empty($products)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= $p['name'] ?></td>
                        <td>Rs. <?= $p['price'] ?></td>
                        <td><?= $p['quantity'] ?></td>
                        <td>Rs. <?= $p['subtotal'] ?></td>
                        <td>
                            <a href="remove.php?id=<?= $p['product_id'] ?>" class="btn btn-sm btn-danger">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr class="table-info fw-bold">
                    <td colspan="3" class="text-end">Total:</td>
                    <td>Rs. <?= $total ?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <form action="../orders/place_order.php" method="POST">
            <input type="hidden" name="total" value="<?= $total ?>">
            <button type="submit" class="btn btn-success">Place Order</button>
        </form>
    <?php endif; ?>
</div>

 
