<?php
// Employees Management
$page_title = "Employees Management";
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;
require_once $projectRoot . '/header.php';

// Fetch employees
$result = $conn->query("SELECT * FROM employees");
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Employees Management</h2>
        <a href="add.php" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Add Employee
        </a>
    </div>

    <div class="table-responsive shadow-sm">
        <table class="table table-hover align-middle table-bordered">
            <thead class="table-dark text-center">
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Salary</th>
                    <th>Shift</th>
                    <th>Status</th>
                    <th style="width: 130px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['role']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td>Rs. <?= number_format($row['salary']) ?></td>
                    <td><?= htmlspecialchars($row['shift_time']) ?></td>
                    <td>
                        <span class="badge bg-<?= $row['status'] ? 'success' : 'secondary' ?>">
                            <?= $row['status'] ? 'Active' : 'Inactive' ?>
                        </span>
                    </td>
                    <td class="text-center ">
                        <a href="edit.php?id=<?= $row['employee_id'] ?>" class="btn btn-sm btn-outline-primary me-1 mb-2"  >
                            <i class="bi bi-pencil-square"></i>Edit
                        </a>
                        <a href="delete.php?id=<?= $row['employee_id'] ?>" class="btn btn-sm btn-outline-danger"  
                           onclick="return confirm('Are you sure you want to delete this employee?')">
                            <i class="bi bi-trash"></i>Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
