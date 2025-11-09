<?php
// Define your base folder relative to document root (adjust if needed)
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/header.php';
$id = $_GET['id'];
$conn->query("DELETE FROM inventory WHERE inventory_id = $id");
header("Location: index.php");
