<?php
require '../db.php';
require '../auth.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$stmt = $conn->query("
    SELECT s.stock_id, p.name AS product, sup.name AS supplier, s.quantity_added, s.date_added
    FROM stock s
    JOIN products p ON s.product_id = p.product_id
    JOIN suppliers sup ON s.supplier_id = sup.supplier_id
    ORDER BY s.date_added DESC
");
$entries = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stock Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2 class="mb-4">📥 Stock Management</h2>

        <a href="add.php" class="btn btn-primary mb-3">+ Add Stock</a>
        <a href="../dashboard.php" class="btn btn-secondary mb-3 ms-2">Back to Dashboard</a>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th><th>Product</th><th>Supplier</th><th>Quantity</th><th>Date Added</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entries as $e): ?>
                <tr>
                    <td><?= $e['stock_id'] ?></td>
                    <td><?= $e['product'] ?></td>
                    <td><?= $e['supplier'] ?></td>
                    <td><?= $e['quantity_added'] ?></td>
                    <td><?= $e['date_added'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
