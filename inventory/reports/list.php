<?php
require '../db.php';
require '../auth.php';
session_start();

if (!isset($_SESSION['user_id']) || !isAdmin()) {
    die("Access denied. Admins only.");
}

$stmt = $conn->query("
    SELECT p.name, SUM(s.quantity_sold) AS total_qty, SUM(s.total_amount) AS total_revenue
    FROM sales s
    JOIN products p ON s.product_id = p.product_id
    GROUP BY p.product_id
    ORDER BY total_revenue DESC
");
$report = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sales Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">📊 Sales Report</h2>
        <a href="../dashboard.php" class="btn btn-secondary mb-3">⬅ Back to Dashboard</a>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Product</th>
                    <th>Total Quantity Sold</th>
                    <th>Total Revenue</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($report as $row): ?>
                <tr>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['total_qty'] ?></td>
                    <td>$<?= number_format($row['total_revenue'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
