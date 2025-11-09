<?php
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;
require_once $projectRoot . '/header.php';

if (!isset($_GET['id'])) {
    die("Order ID is required.");
}

$order_id = (int)$_GET['id'];
$order = $conn->query("SELECT * FROM orders WHERE order_id = $order_id")->fetch_assoc();
$customers = $conn->query("SELECT customer_id, full_name FROM customers");
$order_items = $conn->query("SELECT * FROM order_items WHERE order_id = $order_id");

$productList = [];
$products = $conn->query("SELECT product_id, name FROM products");
while ($row = $products->fetch_assoc()) {
    $productList[] = $row;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $order_date = $_POST['order_date'];
    $delivery_date = $_POST['delivery_date'];
    $status = $_POST['status'];
    $notes = $_POST['notes'];

    $stmt = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    $total_amount = 0;
    foreach ($_POST['product_id'] as $index => $product_id) {
        $quantity = $_POST['quantity'][$index];
        $price = $_POST['price'][$index];

        if ($product_id && $quantity && $price) {
            $item_total = $quantity * $price;
            $total_amount += $item_total;

            $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
            $stmt->execute();
        }
    }

    $stmt = $conn->prepare("UPDATE orders SET customer_id=?, order_date=?, delivery_date=?, status=?, total_amount=?, notes=? WHERE order_id=?");
    $stmt->bind_param("isssssi", $customer_id, $order_date, $delivery_date, $status, $total_amount, $notes, $order_id);
    $stmt->execute();

    echo "<script>alert('Order updated successfully!'); location.href='index.php';</script>";
    exit;
}
?>

<div class="container py-4 shadow-lg mt-5 mb-5 rounded-4">
    <h2 class="mb-4">Edit Order #<?= htmlspecialchars($order_id) ?></h2>
    <form method="post" class="row g-3">

        <div class="col-md-6">
            <label class="form-label">Customer</label>
            <select name="customer_id" class="form-select" required>
                <option value="">-- Select Customer --</option>
                <?php while ($c = $customers->fetch_assoc()): ?>
                    <option value="<?= $c['customer_id'] ?>" <?= ($order['customer_id'] == $c['customer_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['full_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Order Date</label>
            <input type="date" name="order_date" class="form-control"
                   value="<?= isset($order['order_date']) ? date('Y-m-d', strtotime($order['order_date'])) : '' ?>" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Delivery Date</label>
            <input type="date" name="delivery_date" class="form-control"
                   value="<?= isset($order['delivery_date']) ? date('Y-m-d', strtotime($order['delivery_date'])) : '' ?>">
        </div>

        <div class="col-md-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <?php
                $statuses = ['pending', 'processing', 'ready', 'delivered', 'cancelled'];
                foreach ($statuses as $s):
                ?>
                    <option value="<?= $s ?>" <?= ($order['status'] === $s) ? 'selected' : '' ?>>
                        <?= ucfirst($s) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-9">
            <label class="form-label">Notes</label>
            <textarea name="notes" class="form-control" rows="2"><?= htmlspecialchars($order['notes']) ?></textarea>
        </div>

        <div class="col-12 mt-4">
            <h4>Order Items</h4>
            <table class="table table-bordered align-middle" id="items-table">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th width="20%">Qty</th>
                        <th width="20%">Price</th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($item = $order_items->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <select name="product_id[]" class="form-select" required>
                                <option value="">-- Select --</option>
                                <?php foreach ($productList as $p): ?>
                                    <option value="<?= $p['product_id'] ?>" <?= ($p['product_id'] == $item['product_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($p['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><input type="number" name="quantity[]" class="form-control" value="<?= $item['quantity'] ?>" required></td>
                        <td><input type="number" step="0.01" name="price[]" class="form-control" value="<?= $item['price'] ?>" required></td>
                        <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">×</button></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            <button type="button" class="btn btn-outline-success" onclick="addRow()">+ Add Item</button>
        </div>

        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-primary">Update Order</button>
            <a href="index.php" class="btn btn-secondary ms-2">Cancel</a>
        </div>
    </form>
</div>

<script>
    const productList = <?= json_encode($productList) ?>;

    function addRow() {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <select name="product_id[]" class="form-select" required>
                    <option value="">-- Select Product --</option>
                    ${productList.map(p => `<option value="${p.product_id}">${p.name}</option>`).join('')}
                </select>
            </td>
            <td><input type="number" name="quantity[]" class="form-control" required></td>
            <td><input type="number" step="0.01" name="price[]" class="form-control" required></td>
            <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">×</button></td>
        `;
        document.querySelector("#items-table tbody").appendChild(row);
    }

    function removeRow(btn) {
        btn.closest("tr").remove();
    }
</script>
