<?php
require '../db.php';
require '../auth.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2 class="mb-4">Products</h2>

        <a href="add.php" class="btn btn-primary mb-3">+ Add Product</a>
        <a href="../dashboard.php" class="btn btn-secondary mb-3 ms-2">Back to Dashboard</a>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td><?= $p['product_id'] ?></td>
                    <td><?= $p['name'] ?></td>
                    <td><?= $p['category'] ?></td>
                    <td>$<?= number_format($p['price'], 2) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $p['product_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <?php if (isAdmin()): ?>
                            <a href="delete.php?id=<?= $p['product_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete product?')">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
