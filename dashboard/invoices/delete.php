<?php
//redirect_if_not_logged_in();
 $page_title = "Add invoices";
 // Define your base folder relative to document root (adjust if needed)
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/header.php';
$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM invoices WHERE invoice_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php");
