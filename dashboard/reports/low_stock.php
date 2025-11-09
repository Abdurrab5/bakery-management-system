<?php
$page_title = "Low Stock Items";
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;
require_once $projectRoot . '/includes/db_connect.php';

// Fetch low stock items
$sql = "SELECT item_name, unit, quantity, min_required 
        FROM inventory 
        WHERE quantity < min_required 
        ORDER BY item_name";
$result = $conn->query($sql);
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Low Stock Items</h2>
    <input type="text" id="searchInput" class="form-control w-25" placeholder="Search item...">
  </div>

  <?php if ($result->num_rows > 0): ?>
    <div class="alert alert-warning">These items are below the minimum stock level.</div>
    <div class="table-responsive">
      <table class="table table-bordered table-striped" id="lowStockTable">
        <thead class="table-dark">
          <tr>
            <th>Item Name</th>
            <th>Unit</th>
            <th>Quantity</th>
            <th>Min Required</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['item_name']) ?></td>
              <td><?= $row['unit'] ?></td>
              <td class="text-danger fw-bold"><?= $row['quantity'] ?></td>
              <td><?= $row['min_required'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-success">All stock levels are sufficient.</div>
  <?php endif; ?>
</div>

<script>
// Client-side filtering for table
document.getElementById("searchInput").addEventListener("keyup", function () {
  let filter = this.value.toLowerCase();
  let rows = document.querySelectorAll("#lowStockTable tbody tr");

  rows.forEach(row => {
    let text = row.cells[0].textContent.toLowerCase();
    row.style.display = text.includes(filter) ? "" : "none";
  });
});
</script>

 
