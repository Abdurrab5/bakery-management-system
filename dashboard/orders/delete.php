<?php
// Define your base folder relative to document root (adjust if needed)
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete order items first
    $conn->query("DELETE FROM order_items WHERE order_id = $id");

    // Then delete the order
    $conn->query("DELETE FROM orders WHERE order_id = $id");
}

header("Location: index.php");
exit;
