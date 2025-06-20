<?php
require '../db.php';
session_start();

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM suppliers WHERE supplier_id = ?");
$stmt->execute([$id]);
$supplier = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $contact = $_POST['contact'];

    $stmt = $conn->prepare("UPDATE suppliers SET name=?, contact_info=? WHERE supplier_id=?");
    $stmt->execute([$name, $contact, $id]);
    header("Location: list.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title mb-4">Edit Supplier</h3>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Supplier Name:</label>
                    <input type="text" name="name" value="<?= $supplier['name'] ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact Info:</label>
                    <textarea name="contact" class="form-control"><?= $supplier['contact_info'] ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">Update Supplier</button>
            </form>
            <a href="list.php" class="btn btn-link mt-3">⬅ Back to Supplier List</a>
        </div>
    </div>
</div>
</body>
</html>
