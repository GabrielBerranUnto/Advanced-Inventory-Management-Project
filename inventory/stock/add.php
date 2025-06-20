<?php
require '../db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'];
    $supplierName = $_POST['supplier_name'];
    $quantity = $_POST['quantity'];

    // Check or create product
    $stmt = $conn->prepare("SELECT product_id FROM products WHERE name = ?");
    $stmt->execute([$productName]);
    $product = $stmt->fetch();
    if (!$product) {
        $conn->prepare("INSERT INTO products (name) VALUES (?)")->execute([$productName]);
        $productId = $conn->lastInsertId();
    } else {
        $productId = $product['product_id'];
    }

    // Check or create supplier
    $stmt = $conn->prepare("SELECT supplier_id FROM suppliers WHERE name = ?");
    $stmt->execute([$supplierName]);
    $supplier = $stmt->fetch();
    if (!$supplier) {
        $conn->prepare("INSERT INTO suppliers (name) VALUES (?)")->execute([$supplierName]);
        $supplierId = $conn->lastInsertId();
    } else {
        $supplierId = $supplier['supplier_id'];
    }

    // Insert stock record
    $stmt = $conn->prepare("INSERT INTO stock (product_id, supplier_id, quantity_added) VALUES (?, ?, ?)");
    $stmt->execute([$productId, $supplierId, $quantity]);

    header("Location: list.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title mb-4">Add Stock Entry</h3>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Product Name:</label>
                    <input type="text" name="product_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Supplier Name:</label>
                    <input type="text" name="supplier_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Quantity:</label>
                    <input type="number" name="quantity" class="form-control" min="1" required>
                </div>

                <button type="submit" class="btn btn-success w-100">Add Stock</button>
            </form>
            <a href="list.php" class="btn btn-link mt-3">⬅ Back to Stock List</a>
        </div>
    </div>
</div>
</body>
</html>
