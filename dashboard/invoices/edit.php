<?php
// redirect_if_not_logged_in();
$page_title = "Edit Invoice";

// Define your base folder
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;
require_once $projectRoot . '/header.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM invoices WHERE invoice_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$invoice = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $invoice_date = $_POST['invoice_date'];
    $tax = $_POST['tax'];
    $discount = $_POST['discount'];
    $total_due = $_POST['total_due'];
    $payment_method = $_POST['payment_method'];

    $stmt = $conn->prepare("UPDATE invoices SET order_id=?, invoice_date=?, tax=?, discount=?, total_due=?, payment_method=? WHERE invoice_id=?");
    $stmt->bind_param("isdddsi", $order_id, $invoice_date, $tax, $discount, $total_due, $payment_method, $id);
    $stmt->execute();
    header("Location: index.php");
    exit;
}
?>

<div class="container mt-5 mb-5 ">
    <div class="card shadow-lg ">
        <div class="card-header bg-primary text-white">
            <h4>Edit Invoice</h4>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Order ID</label>
                    <input type="number" name="order_id" class="form-control" value="<?= $invoice['order_id'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Invoice Date</label>
                    <input type="date" name="invoice_date" class="form-control" value="<?= $invoice['invoice_date'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tax</label>
                    <input type="number" step="0.01" name="tax" class="form-control" value="<?= $invoice['tax'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Discount</label>
                    <input type="number" step="0.01" name="discount" class="form-control" value="<?= $invoice['discount'] ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Total Due</label>
                    <input type="number" step="0.01" name="total_due" class="form-control" value="<?= $invoice['total_due'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Payment Method</label>
                    <input type="text" name="payment_method" class="form-control" value="<?= $invoice['payment_method'] ?>" required>
                </div>

                <button type="submit" class="btn btn-success">Update Invoice</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
