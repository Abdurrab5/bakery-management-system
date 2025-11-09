<?php
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;
require_once $projectRoot . '/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $salary = $_POST['salary'];
    $shift_time = $_POST['shift_time'];
    $status = isset($_POST['status']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO employees (name, role, phone, email, salary, shift_time, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssdsi", $name, $role, $phone, $email, $salary, $shift_time, $status);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<div class="container mt-5 mb-5">
    <div class="card shadow-lg rounded-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add New Employee</h4>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter employee name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <input type="text" name="role" class="form-control" placeholder="e.g., Baker, Cashier">
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="e.g., 0300-1234567">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="example@domain.com">
                </div>

                <div class="mb-3">
                    <label class="form-label">Salary (PKR)</label>
                    <input type="number" name="salary" step="0.01" class="form-control" placeholder="e.g., 25000" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Shift Time</label>
                    <input type="text" name="shift_time" class="form-control" placeholder="e.g., 9am - 5pm">
                </div>

                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="status" id="statusSwitch" checked>
                    <label class="form-check-label" for="statusSwitch">Active Status</label>
                </div>

                <button type="submit" class="btn btn-success w-100">Save Employee</button>
            </form>
        </div>
    </div>
</div>
