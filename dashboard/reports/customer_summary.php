<?php
 
//redirect_if_not_logged_in();
 $page_title = "Sales Reports ";
$baseURL = '/bakery';

// Full path to project root
$projectRoot = $_SERVER['DOCUMENT_ROOT'] . $baseURL;

// Include header.php dynamically from anywhere
require_once $projectRoot . '/includes/db_connect.php';
?><?php
 

// Fetch customer notification summary
$sql = "
    SELECT c.customer_id, c.username, c.email,
           COUNT(n.notification_id) AS total_notifications,
           MAX(n.sent_at) AS last_notification_date
    FROM customers c
    LEFT JOIN notifications n ON c.customer_id = n.customer_id
    GROUP BY c.customer_id, c.username, c.email
    ORDER BY total_notifications DESC
";

$result = $conn->query($sql);
?>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
 
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Customer Notification Summary</h4>
        </div>
        <div class="card-body">
            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Customer ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Total Notifications</th>
                                <th>Last Notification Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;
                            while ($row = $result->fetch_assoc()):
                            ?>
                            <tr>
                                <td><?= $counter++ ?></td>
                                <td><?= htmlspecialchars($row['customer_id']) ?></td>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= $row['total_notifications'] ?></td>
                                <td><?= $row['last_notification_date'] ? date('Y-m-d H:i', strtotime($row['last_notification_date'])) : 'N/A' ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">No customer data found.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
