<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Get the current directory of the script
$currentDir = dirname($_SERVER['PHP_SELF']);

// Define the base URL if your project is in a subfolder (e.g., /bakery)
$baseURL = '/bakery';

// Get the full server path to the document root
$rootPath = $_SERVER['DOCUMENT_ROOT'];

// Include the DB connection using absolute path
require_once $rootPath . $baseURL . '/includes/db_connect.php';
require_once $rootPath . $baseURL . '/includes/functions.php';
 
$role = $_SESSION['role'] ?? 'guest';
$name = $_SESSION['username'] ?? 'Guest';


?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $page_title ?? "bakery" ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" >
     <!-- Bootstrap CSS (v4 or v5) -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery + Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
 

     
</head> 
      
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container  ">
    <a class="navbar-brand " href="<?= $baseURL ?>/index.php">Bakery Management System </a>
    
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">

    <li class="nav-item"><a class="nav-link" href="<?= $baseURL ?>/index.php">Home</a></li>
      <?php if ($role === 'admin'): ?>
      
      <li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="manageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    Manage
  </a>
  <ul class="dropdown-menu" aria-labelledby="manageDropdown">
   <li><a class="dropdown-item" href="<?= $baseURL ?>/dashboard/products/index.php">Products</a></li>
 <li><a class="dropdown-item" href="<?= $baseURL ?>/dashboard/inventory/index.php">inventory</a></li>
 <li><a class="dropdown-item" href="<?= $baseURL ?>/dashboard/orders/index.php">orders</a></li>
 <li><a class="dropdown-item" href="<?= $baseURL ?>/dashboard/invoices/index.php">Invoices</a></li>
 <li><a class="dropdown-item" href="<?= $baseURL ?>/dashboard/reports/index.php">Reports</a></li>
 <li><a class="dropdown-item" href="<?= $baseURL ?>/dashboard/notifications/index.php">notifications</a></li>
 <li><a class="dropdown-item" href="<?= $baseURL ?>/dashboard/employees/index.php">employees</a></li>
 <li><a class="dropdown-item" href="<?= $baseURL ?>/dashboard/customers/index.php">Customers</a></li>
     
  </ul>
</li>

<li class="nav-item"><a class="nav-link" href="<?= $baseURL ?> "> </a></li>

      <?php endif; ?> 
    <li class="nav-item"><a class="nav-link" href="<?= $baseURL ?>/about.php">About</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= $baseURL ?>/contact.php">Contact</a></li>
       
      
        <?php if ($role === 'admin'): ?>


            <li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    Admin Panel
  </a>
  <ul class="dropdown-menu" aria-labelledby="adminDropdown">
    <li><a class="dropdown-item" href="<?= $baseURL ?> "> </a></li>
    <li><a class="dropdown-item" href="<?= $baseURL ?> "> </a></li>
 
  </ul>
</li>
<?php elseif ($role === 'Customer'): ?>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      <?php echo $name; ?>
    </a>
    <ul class="dropdown-menu" aria-labelledby="userDropdown">
      <li><a class="dropdown-item" href="<?= $baseURL ?>/customer/products/index.php">Browse Products</a></li>
      <li><a class="dropdown-item" href="<?= $baseURL ?>/customer/cart/view.php">My Cart</a></li>
      <li><a class="dropdown-item" href="<?= $baseURL ?>/customer/orders/index.php">My Orders</a></li>
       
      <li><a class="dropdown-item" href="<?= $baseURL ?>/customer/profile/profile.php">My Profile</a></li>
  
    </ul>
  </li>
<?php endif; ?>

        <?php if ($role !== 'guest'): ?>
        <li class="nav-item"><a class="nav-link" href="<?= $baseURL ?>/logout.php">Logout </a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="<?= $baseURL ?>/login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= $baseURL ?>/register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
