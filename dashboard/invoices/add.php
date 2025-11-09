<?php
//redirect_if_not_logged_in();
 $page_title = "Add invoices";
 // Define your base folder relative to document root (adjust if needed)
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/header.php';
?>
<?php
 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $invoice_date = $_POST['invoice_date'];
    $tax = $_POST['tax'];
    $discount = $_POST['discount'];
    $total_due = $_POST['total_due'];
    $payment_method = $_POST['payment_method'];

    $stmt = $conn->prepare("INSERT INTO invoices (order_id, invoice_date, tax, discount, total_due, payment_method) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isddds", $order_id, $invoice_date, $tax, $discount, $total_due, $payment_method);
    $stmt->execute();
    header("Location: index.php");
}
?>

<form method="POST">
    Order ID: <input type="number" name="order_id" required><br>
    Invoice Date: <input type="date" name="invoice_date" required><br>
    Tax: <input type="number" step="0.01" name="tax" required><br>
    Discount: <input type="number" step="0.01" name="discount"><br>
    Total Due: <input type="number" step="0.01" name="total_due" required><br>
    Payment Method: <input type="text" name="payment_method" required><br>
    <button type="submit">Add Invoice</button>
</form>
