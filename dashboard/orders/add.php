<?php
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;
require_once $projectRoot . '/header.php';

$customers = $conn->query("SELECT customer_id, full_name FROM customers");
$products = $conn->query("SELECT product_id, name, price FROM products WHERE is_available = 1");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // your PHP logic here (unchanged)
}
?>

<div class="container py-5">
    <h2 class="mb-4 text-primary">Place New Order</h2>

    <form method="post" class="card shadow p-4">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Customer</label>
                <select name="customer_id" class="form-select" required>
                    <option value="">-- Select Customer --</option>
                    <?php while($row = $customers->fetch_assoc()): ?>
                        <option value="<?= $row['customer_id'] ?>"><?= htmlspecialchars($row['full_name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Order Date</label>
                <input type="date" name="order_date" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Delivery Date</label>
                <input type="date" name="delivery_date" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <input type="text" name="status" class="form-control" value="Pending">
            </div>
            <div class="col-md-6">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2"></textarea>
            </div>
        </div>

        <h5 class="mb-3">Products</h5>
        <div id="products" class="mb-3">
            <div class="row g-3 product-row">
                <div class="col-md-5">
                    <label class="form-label">Product</label>
                    <select name="product_id[]" class="form-select" onchange="updatePrice(this)" required>
                        <option value="">-- Select Product --</option>
                        <?php
                        $products->data_seek(0);
                        $product_list = [];
                        while ($p = $products->fetch_assoc()):
                            $product_list[$p['product_id']] = $p;
                        ?>
                            <option value="<?= $p['product_id'] ?>" data-price="<?= $p['price'] ?>">
                                <?= htmlspecialchars($p['name']) ?> (Rs. <?= number_format($p['price'], 2) ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Quantity</label>
                    <input name="quantity[]" type="number" value="1" min="1" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Price</label>
                    <input name="price[]" type="number" step="0.01" class="form-control" readonly required>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <button type="button" class="btn btn-outline-primary" onclick="addProduct()">
                <i class="bi bi-plus-circle"></i> Add Another Product
            </button>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-cart-check"></i> Place Order
        </button>
    </form>
</div>

<!-- BOOTSTRAP ICONS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<script>
const productList = <?= json_encode($product_list) ?>;

function updatePrice(selectEl) {
    const priceInput = selectEl.closest('.product-row').querySelector('input[name="price[]"]');
    const selectedProductId = selectEl.value;
    priceInput.value = selectedProductId && productList[selectedProductId] ? productList[selectedProductId].price : '';
}

function addProduct() {
    const container = document.getElementById('products');
    const div = document.createElement('div');
    div.className = "row g-3 product-row mt-2";
    div.innerHTML = `
        <div class="col-md-5">
            <label class="form-label">Product</label>
            <select name="product_id[]" class="form-select" onchange="updatePrice(this)" required>
                <option value="">-- Select Product --</option>
                ${Object.entries(productList).map(([id, p]) =>
                    `<option value="${id}" data-price="${p.price}">${p.name} (Rs. ${parseFloat(p.price).toFixed(2)})</option>`).join('')}
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Quantity</label>
            <input name="quantity[]" type="number" value="1" min="1" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label class="form-label">Price</label>
            <input name="price[]" type="number" step="0.01" class="form-control" readonly required>
        </div>
    `;
    container.appendChild(div);
}
</script>
