<?php
//redirect_if_not_logged_in();
$page_title = "Reports Management";
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header
require_once $projectRoot . '/header.php';
?>

<h2 class="mb-4">Reports Management</h2>

<ul class="nav nav-tabs" id="reportTabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="customer-tab" data-toggle="tab" href="#customer" role="tab">Customer Summary</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="salary-tab" data-toggle="tab" href="#salary" role="tab">Employees Salary</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="inventory-tab" data-toggle="tab" href="#inventory" role="tab">Inventory Status</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="stock-tab" data-toggle="tab" href="#stock" role="tab">Low Stock</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="order-tab" data-toggle="tab" href="#order" role="tab">Order Status</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="sale-tab" data-toggle="tab" href="#sale" role="tab">Sales Report</a>
    </li>
</ul>

<div class="tab-content mt-3" id="reportTabsContent">
    <div class="tab-pane fade show active" id="customer" role="tabpanel">
        <iframe src="customer_summary.php" style="width:100%; height:600px; border:none;"></iframe>
    </div>
    <div class="tab-pane fade" id="salary" role="tabpanel">
        <iframe src="employee_salary.php" style="width:100%; height:600px; border:none;"></iframe>
    </div>
    <div class="tab-pane fade" id="inventory" role="tabpanel">
        <iframe src="inventory_status.php" style="width:100%; height:600px; border:none;"></iframe>
    </div>
    <div class="tab-pane fade" id="stock" role="tabpanel">
        <iframe src="low_stock.php" style="width:100%; height:600px; border:none;"></iframe>
    </div>
    <div class="tab-pane fade" id="order" role="tabpanel">
        <iframe src="order_status.php" style="width:100%; height:600px; border:none;"></iframe>
    </div>
    <div class="tab-pane fade" id="sale" role="tabpanel">
        <iframe src="sales_report.php" style="width:100%; height:600px; border:none;"></iframe>
    </div>
</div>
