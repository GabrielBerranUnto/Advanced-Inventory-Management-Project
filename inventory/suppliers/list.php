<?php
require '../db.php';
require '../auth.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$stmt = $conn->query("SELECT * FROM suppliers");
$suppliers = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Suppliers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <h2 class="mb-4">🏢 Suppliers</h2>

        <a href="add.php" class="btn btn-primary mb-3">+ Add Supplier</a>
        <a href="../dashboard.php" class="btn btn-secondary mb-3 ms-2">Back to Dashboard</a>

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th><th>Name</th><th>Contact Info</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($suppliers as $s): ?>
                <tr>
                    <td><?= $s['supplier_id'] ?></td>
                    <td><?= $s['name'] ?></td>
                    <td><?= $s['contact_info'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= $s['supplier_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <?php if (isAdmin()): ?>
                            <a href="delete.php?id=<?= $s['supplier_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete supplier?')">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
