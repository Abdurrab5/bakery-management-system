<?php
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;
require_once $projectRoot . '/header.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM customers WHERE customer_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $loyalty_points = $_POST['loyalty_points'];

    $stmt = $conn->prepare("UPDATE customers SET full_name=?, email=?, phone=?, address=?, loyalty_points=? WHERE customer_id=?");
    $stmt->bind_param("ssssii", $full_name, $email, $phone, $address, $loyalty_points, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        $error = "Failed to update customer.";
    }
}
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Customer Information</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" name="full_name" id="full_name" class="form-control" value="<?= htmlspecialchars($customer['full_name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($customer['email']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="<?= htmlspecialchars($customer['phone']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" id="address" class="form-control" rows="2"><?= htmlspecialchars($customer['address']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="loyalty_points" class="form-label">Loyalty Points</label>
                            <input type="number" name="loyalty_points" id="loyalty_points" class="form-control" value="<?= (int)$customer['loyalty_points'] ?>">
                        </div>
                        <button type="submit" class="btn btn-success">Update Customer</button>
                        <a href="index.php" class="btn btn-secondary ms-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
