<?php
//redirect_if_not_logged_in();
$page_title = "Invoice Detail";

// Define your base folder relative to document root
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically
require_once $projectRoot . '/header.php';

$invoice_id = $_GET['invoice_id'] ?? 0;

// Fetch invoice and order
$stmt = $conn->prepare("
    SELECT i.*, o.*, c.full_name, c.phone, c.address
    FROM invoices i
    JOIN orders o ON i.order_id = o.order_id
    JOIN customers c ON o.customer_id = c.customer_id
    WHERE i.invoice_id = ?");
$stmt->bind_param("i", $invoice_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

// Fetch order items
$items = $conn->query("
    SELECT oi.*, p.name
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    WHERE oi.order_id = {$data['order_id']}");
?>

<div class="container mt-5" id="invoice-content">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Invoice #<?= $invoice_id ?></h2>
        <button class="btn btn-outline-primary" onclick="window.print()">
            <i class="bi bi-printer"></i> Print
        </button>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Customer Details</h5>
            <p><strong>Name:</strong> <?= $data['full_name'] ?></p>
            <p><strong>Address:</strong> <?= $data['address'] ?></p>
            <p><strong>Phone:</strong> <?= $data['phone'] ?></p>
            <p><strong>Invoice Date:</strong> <?= $data['invoice_date'] ?></p>
            <p><strong>Payment Method:</strong> <?= $data['payment_method'] ?></p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Order Summary</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1; $total = 0;
                        while ($item = $items->fetch_assoc()): 
                            $sub = $item['quantity'] * $item['price'];
                            $total += $sub;
                        ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>Rs. <?= number_format($item['price'], 2) ?></td>
                            <td>Rs. <?= number_format($sub, 2) ?></td>
                        </tr>
                        <?php endwhile; ?>
                        <tr>
                            <th colspan="4" class="text-end">Subtotal</th>
                            <td>Rs. <?= number_format($total, 2) ?></td>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-end">Tax</th>
                            <td>Rs. <?= number_format($data['tax'], 2) ?></td>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-end">Discount</th>
                            <td>Rs. <?= number_format($data['discount'], 2) ?></td>
                        </tr>
                        <tr class="table-success">
                            <th colspan="4" class="text-end"><strong>Total Due</strong></th>
                            <td><strong>Rs. <?= number_format($data['total_due'], 2) ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Add print-friendly CSS -->
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #invoice-content, #invoice-content * {
            visibility: visible;
        }
        #invoice-content {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        button {
            display: none !important;
        }
    }
</style>
