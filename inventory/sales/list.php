<?php
require '../db.php';
require '../auth.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$stmt = $conn->query("
    SELECT s.sale_id, p.name AS product, s.quantity_sold, s.total_amount, s.sale_date
    FROM sales s
    JOIN products p ON s.product_id = p.product_id
    ORDER BY s.sale_date DESC
");
$sales = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sales</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2 class="mb-4">💰 Sales Records</h2>

        <a href="add.php" class="btn btn-primary mb-3">+ Record Sale</a>
        <a href="../dashboard.php" class="btn btn-secondary mb-3 ms-2">Back to Dashboard</a>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th><th>Product</th><th>Qty Sold</th><th>Total</th><th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sales as $s): ?>
                <tr>
                    <td><?= $s['sale_id'] ?></td>
                    <td><?= $s['product'] ?></td>
                    <td><?= $s['quantity_sold'] ?></td>
                    <td>$<?= number_format($s['total_amount'], 2) ?></td>
                    <td><?= $s['sale_date'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
