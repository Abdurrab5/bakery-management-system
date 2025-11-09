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
 

$action = $_POST['action'];

if ($action == 'add') {
    $stmt = $conn->prepare("INSERT INTO notifications (customer_id, message, type, sent_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iss", $_POST['customer_id'], $_POST['message'], $_POST['type']);
    $stmt->execute();
} elseif ($action == 'edit') {
    $stmt = $conn->prepare("UPDATE notifications SET customer_id=?, message=?, type=? WHERE notification_id=?");
    $stmt->bind_param("issi", $_POST['customer_id'], $_POST['message'], $_POST['type'], $_POST['notification_id']);
    $stmt->execute();
}

header("Location: index.php");
exit;
