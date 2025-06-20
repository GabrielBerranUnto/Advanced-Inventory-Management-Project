<?php
require '../db.php';
session_start();

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("UPDATE products SET name=?, category=?, price=? WHERE product_id=?");
    $stmt->execute([$name, $category, $price, $id]);
    header("Location: list.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title mb-4">Edit Product</h3>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Product Name:</label>
                    <input type="text" name="name" value="<?= $product['name'] ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category:</label>
                    <input type="text" name="category" value="<?= $product['category'] ?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Price:</label>
                    <input type="number" name="price" step="0.01" value="<?= $product['price'] ?>" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Update Product</button>
            </form>
            <a href="list.php" class="btn btn-link mt-3">⬅ Back to Product List</a>
        </div>
    </div>
</div>
</body>
</html>
