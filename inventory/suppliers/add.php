<?php
require '../db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $contact = $_POST['contact'];

    $stmt = $conn->prepare("INSERT INTO suppliers (name, contact_info) VALUES (?, ?)");
    $stmt->execute([$name, $contact]);
    header("Location: list.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="card-title mb-4">Add New Supplier</h3>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Name:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact Info:</label>
                    <textarea name="contact" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-success w-100">Add Supplier</button>
            </form>
            <a href="list.php" class="btn btn-link mt-3">⬅ Back to Supplier List</a>
        </div>
    </div>
</div>
</body>
</html>
