<?php
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;
require_once $projectRoot . '/header.php';

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>Invalid request.</div>";
    exit;
}

$id = intval($_GET['id']);

// Fetch employee
$stmt = $conn->prepare("SELECT * FROM employees WHERE employee_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $salary = $_POST['salary'];
    $shift_time = $_POST['shift_time'];
    $status = isset($_POST['status']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE employees SET name=?, role=?, phone=?, email=?, salary=?, shift_time=?, status=? WHERE employee_id=?");
    $stmt->bind_param("ssssdsii", $name, $role, $phone, $email, $salary, $shift_time, $status, $id);
    $stmt->execute();

    echo "<script>window.location.href='index.php?updated=1';</script>";
    exit;
}
?>

<div class="container mt-5">
    <div class="card shadow rounded">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Employee</h4>
        </div>
        <div class="card-body">
            <form method="post" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Role</label>
                    <input type="text" name="role" value="<?= htmlspecialchars($row['role']) ?>" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($row['phone']) ?>" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Salary</label>
                    <input type="number" name="salary" step="0.01" value="<?= htmlspecialchars($row['salary']) ?>" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Shift Time</label>
                    <input type="text" name="shift_time" value="<?= htmlspecialchars($row['shift_time']) ?>" class="form-control">
                </div>

                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="status" id="statusSwitch" <?= $row['status'] ? 'checked' : '' ?>>
                        <label class="form-check-label" for="statusSwitch">Active</label>
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-success">Update Employee</button>
                    <a href="index.php" class="btn btn-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
