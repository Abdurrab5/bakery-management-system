<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Path to PHPMailer autoload
require_once __DIR__ . '/../assets/phpmail/vendor/autoload.php';

function sendCustomerEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // Server config
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Change this to your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your_email@gmail.com'; // Your email
        $mail->Password   = 'your_app_password';    // App Password (not your Gmail password!)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender & recipient
        $mail->setFrom('your_email@gmail.com', 'Bakery Management');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}
