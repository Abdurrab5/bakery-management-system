<?php
 $baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/header.php';

// Check if the user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: ../../login.php");
    exit;
}

 

$customer_id = $_SESSION['customer_id'];

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Update query
    $sql = "UPDATE customers SET full_name = ?, email = ?, phone = ?, address = ? WHERE customer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $full_name, $email, $phone, $address, $customer_id);

    if ($stmt->execute()) {
        $success = "Profile updated successfully.";
    } else {
        $error = "Error updating profile: " . $conn->error;
    }
}

// Fetch existing data
$sql = "SELECT * FROM customers WHERE customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();

if (!$customer) {
    die("Customer not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Your Profile</h2>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" name="full_name" class="form-control" required value="<?= htmlspecialchars($customer['full_name']) ?>">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($customer['email']) ?>">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" required value="<?= htmlspecialchars($customer['phone']) ?>">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" class="form-control" rows="3"><?= htmlspecialchars($customer['address']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-success">Update Profile</button>
        <a href="profile.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
