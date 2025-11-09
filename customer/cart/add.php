<?php
 
 // Define your base folder relative to document root (adjust if needed)
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/header.php';
 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $qty = (int) $_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add or update cart
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $qty;
    } else {
        $_SESSION['cart'][$product_id] = $qty;
    }

    header('Location: view.php');
    exit();
}
