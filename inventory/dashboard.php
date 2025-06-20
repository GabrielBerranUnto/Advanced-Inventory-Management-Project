<?php
session_start();
require 'db.php';
require 'auth.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="card-title mb-3">Welcome, <?= $_SESSION['username'] ?> 👋</h2>
                <p class="mb-4">Role: <?= isAdmin() ? "Admin" : "Staff" ?></p>

                <div class="list-group">
                    <a href="products/list.php" class="list-group-item list-group-item-action">📦 Manage Products</a>
                    <a href="suppliers/list.php" class="list-group-item list-group-item-action">🏢 Manage Suppliers</a>
                    <a href="stock/list.php" class="list-group-item list-group-item-action">📥 Stock Management</a>
                    <a href="sales/list.php" class="list-group-item list-group-item-action">💰 Sales</a>
                <?php if (isAdmin()): ?>
                    <a href="reports/list.php" class="list-group-item list-group-item-action">📊 Reports</a>
                    <a href="reset.php" class="list-group-item list-group-item-action text-danger">
                        🧨 Reset System (Admin Only)
                    </a>
                <?php endif; ?>
                    <a href="logout.php" class="list-group-item list-group-item-action text-danger">🚪 Logout</a>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
