<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    die("Access denied. Admins only.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Disable foreign key checks to allow full reset
    $conn->exec("SET FOREIGN_KEY_CHECKS = 0");

    // Truncate all tables
    $tables = ['sales', 'stock', 'supplier_products', 'products', 'suppliers', 'users'];

    foreach ($tables as $table) {
        $conn->exec("TRUNCATE TABLE $table");
    }

    // Reinsert default role & admin user
    $conn->exec("INSERT INTO users (username, password, role_id) VALUES ('admin', SHA2('admin123', 256), 1)");

    // Enable foreign key checks again
    $conn->exec("SET FOREIGN_KEY_CHECKS = 1");

    echo "<div style='color:green;'>✅ All tables reset successfully!</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>RESET SYSTEM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-danger bg-opacity-10">
<div class="container mt-5" style="max-width: 600px;">
    <div class="card border-danger shadow">
        <div class="card-body">
            <h3 class="card-title text-danger">⚠️ Reset Inventory System</h3>
            <p>This will:</p>
            <ul>
                <li>💣 Delete <strong>ALL</strong> data from Products, Suppliers, Stock, and Sales</li>
                <li>🔁 Reset ID counters to 1</li>
                <li>🔐 Keep only the default Admin login</li>
            </ul>

            <form method="POST">
                <button type="submit" class="btn btn-danger w-100 mt-3"
                        onclick="return confirm('This cannot be undone. Continue?')">
                    RESET EVERYTHING
                </button>
            </form>

            <a href="dashboard.php" class="btn btn-link mt-3">⬅ Back to Dashboard</a>
        </div>
    </div>
</div>
</body>
</html>
