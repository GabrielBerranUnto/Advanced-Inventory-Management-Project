<?php
require '../db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'];
    $qty = $_POST['quantity'];

    // Check product
    $stmt = $conn->prepare("SELECT * FROM products WHERE name = ?");
    $stmt->execute([$productName]);
    $product = $stmt->fetch();

    if (!$product) {
        die("Product not found. Please enter an existing product.");
    }

    $total = $product['price'] * $qty;

    $stmt = $conn->prepare("INSERT INTO sales (product_id, quantity_sold, total_amount) VALUES (?, ?, ?)");
    $stmt->execute([$product['product_id'], $qty, $total]);

    header("Location: list.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Record Sale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title mb-4">Record a Sale</h3>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Product Name:</label>
                    <input type="text" name="product_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Quantity Sold:</label>
                    <input type="number" name="quantity" class="form-control" min="1" required>
                </div>

                <button type="submit" class="btn btn-success w-100">Record Sale</button>
            </form>
            <a href="list.php" class="btn btn-link mt-3">⬅ Back to Sales List</a>
        </div>
    </div>
</div>
</body>
</html>
