<?php
$page_title = "Contact Us";
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;
require_once $projectRoot . '/header.php';
?>

<div class="container mt-5 mb-5">
  <div class="row">
    <!-- Contact Info -->
    <div class="col-md-6">
      <h2>Get In Touch</h2>
      <p class="text-muted">
        We’d love to hear from you! Whether you have questions, feedback, or special requests, feel free to reach out using the form or contact details below.
      </p>
      <ul class="list-unstyled mt-4">
        <li><strong>📍 Address:</strong> 123 Sweet Street, Bakery Town, Pakistan</li>
        <li><strong>📞 Phone:</strong> +92 300 1234567</li>
        <li><strong>📧 Email:</strong> info@sweetcrumbs.com</li>
        <li><strong>⏰ Hours:</strong> Mon–Sat: 8:00 AM – 8:00 PM</li>
      </ul>
    </div>

    <!-- Contact Form -->
    <div class="col-md-6">
      <form action="/bakery/contact_process.php" method="post" class="p-4 border rounded shadow-sm bg-light">
        <h4 class="mb-3">Send Us a Message</h4>
        <div class="mb-3">
          <label for="name" class="form-label">Your Name</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Your Email</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
          <label for="message" class="form-label">Message</label>
          <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Message</button>
      </form>
    </div>
  </div>
</div>

 
