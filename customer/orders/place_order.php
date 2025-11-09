<?php
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;
require_once $projectRoot . '/header.php';

if (!isset($_SESSION['customer_id']) || empty($_SESSION['cart'])) {
    header('Location: ../../login.php');
    exit();
}

$customer_id = $_SESSION['customer_id'];
$cart = $_SESSION['cart'];
$total = $_POST['total'] ?? 0;

mysqli_begin_transaction($conn);

try {
    // 1. Insert into orders
    $stmt = $conn->prepare("INSERT INTO orders (customer_id, total_amount, status) VALUES (?, ?, 'Pending')");
    $stmt->bind_param("id", $customer_id, $total);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // 2. Insert into order_items
    $ids = implode(',', array_map('intval', array_keys($cart))); // Ensure IDs are integers
    $result = mysqli_query($conn, "SELECT product_id, price FROM products WHERE product_id IN ($ids)");

    while ($row = mysqli_fetch_assoc($result)) {
        $product_id = $row['product_id'];
        $price = $row['price'];
       $qty = isset($cart[(int)$product_id]) ? (int)$cart[(int)$product_id] : 0;


        if ($qty > 0) {
            $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $order_id, $product_id, $qty, $price);
            $stmt->execute();
            $stmt->close();
        }
        // 3. Insert into invoices
$invoice_date = date('Y-m-d H:i:s');
$tax = 0.0; // Or calculate dynamically
$discount = 0.0; // Or calculate dynamically
$total_due = $total + $tax - $discount;
$payment_method = 'Cash'; // Or get from form input

$stmt = $conn->prepare("INSERT INTO invoices (order_id, invoice_date, tax, discount, total_due, payment_method) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isddds", $order_id, $invoice_date, $tax, $discount, $total_due, $payment_method);
$stmt->execute();
$stmt->close();

    }

    mysqli_commit($conn);
    unset($_SESSION['cart']); // Empty cart
    header("Location: ../orders/index.php?success=1");
    exit();

} catch (Exception $e) {
    mysqli_rollback($conn);
    die("Order failed: " . $e->getMessage());
}
?>
