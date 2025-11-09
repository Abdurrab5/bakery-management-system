<?php

function getTotalUsers($conn) {
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function getTotalCars($conn) {
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM cars");
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function getTotalOrders($conn) {
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM orders");
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function getPendingOrders($conn) {
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM orders WHERE status = 'Pending'");
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

 
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function redirect($url) {
    header("Location: $url");
    exit;
}

 
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function redirect_if_not_logged_in() {
    if (!is_logged_in()) {
        header("Location: /login.php");
        exit();
    }
}
 
// require_once 'email_config.php'; // path to the above file

// $customer_email = "customer@example.com";
// $subject = "Thank you for your order!";
// $body = "<h3>Dear Customer,</h3><p>Your order has been received. We will notify you when it's ready.</p>";

// if (sendCustomerEmail($customer_email, $subject, $body)) {
//     echo "Email sent!";
// } else {
//     echo "Email failed.";
// }

?>
