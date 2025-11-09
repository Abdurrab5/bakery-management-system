<?php 


require_once '../includes/email_config.php';

$email = 'customer@example.com';
$subject = 'New Notification';
$message = '<h3>Hello!</h3><p>You have a new update from Bakery Management System.</p>';

if (sendCustomerEmail($email, $subject, $message)) {
    echo "Email sent successfully.";
} else {
    echo "Failed to send email.";
}
