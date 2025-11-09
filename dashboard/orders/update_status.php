<?php
// Define your base folder relative to document root (adjust if needed)
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/header.php';

 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id']);
    $status = $_POST['status'];

    if ($status === 'delivered') {
        // Set delivery_date to current date when status is delivered
        $delivery_date = date('Y-m-d');
        $stmt = $conn->prepare("UPDATE orders SET status = ?, delivery_date = ? WHERE order_id = ?");
        $stmt->bind_param("ssi", $status, $delivery_date, $order_id);
    } else {
        // Keep existing delivery_date if not delivered
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
        $stmt->bind_param("si", $status, $order_id);
    }

    if ($stmt->execute()) {
        header("Location: index.php?status=updated");
        exit;
    } else {
        echo "Error updating status.";
    }
}

?>
