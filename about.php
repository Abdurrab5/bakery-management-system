<?php
$page_title = "About Us";
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;
require_once $projectRoot . '/header.php';
?>

<div class="container mt-5">
  <div class="row align-items-center">
    <div class="col-md-6 mb-4 mb-md-0">
      <img src="assets/about-us.jpg" alt="Our Bakery" class="img-fluid rounded shadow">
    </div>
    <div class="col-md-6">
      <h2 class="mb-4">Welcome to Our Bakery</h2>
      <p class="lead text-muted">
        At <strong>Sweet Crumbs Bakery</strong>, we blend tradition with innovation to bring you the freshest, most delicious baked goods. Since our founding, we’ve dedicated ourselves to quality, flavor, and community.
      </p>
      <p>
        From our oven to your table, every product is crafted with care using high-quality, locally sourced ingredients. Whether you're craving fluffy bread, rich pastries, or custom cakes — we’ve got something to satisfy every sweet tooth.
      </p>
      <p>
        Our team of passionate bakers and friendly staff are committed to delivering an unforgettable experience, whether you're visiting in person or ordering online.
      </p>
      <p class="mt-4">
        <a href="/bakery/contact.php" class="btn btn-primary">Get in Touch</a>
        <a href="/bakery/products.php" class="btn btn-outline-secondary">Browse Our Products</a>
      </p>
    </div>
  </div>
</div>

 
