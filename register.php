<?php
 

// Define base URL and include header
$baseURL = '/bakery';
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;
require_once $projectRoot . '/header.php';
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO customers (username, password, full_name, email, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $password, $full_name, $email, $phone, $address);

    if ($stmt->execute()) {
        header("Location: login.php"); // Redirect to login after successful registration
        exit();
    } else {
        $error = "Registration failed: " . $stmt->error;
    }
}
?>

 

<h2>Customer Registration</h2>
<form method="post">
    <input name="username" placeholder="Username" required><br>
    <input name="full_name" placeholder="Full Name" required><br>
    <input name="email" type="email" placeholder="Email" required><br>
    <input name="phone" placeholder="Phone" required><br>
    <input name="address" placeholder="Address" required><br>
    <input name="password" type="password" placeholder="Password" required><br>
    <button type="submit">Register</button>
</form>

<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
