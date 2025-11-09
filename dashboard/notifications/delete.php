<?php
 
//redirect_if_not_logged_in();
 $page_title = "Notification Management";
// Define your base folder relative to document root (adjust if needed)
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/header.php';
?>

<?php
 
$id = $_GET['id'];
$conn->query("DELETE FROM notifications WHERE notification_id = $id");
header("Location: index.php");
exit;
