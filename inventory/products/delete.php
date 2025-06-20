<?php
require '../db.php';
session_start();

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
$stmt->execute([$id]);

header("Location: list.php");
exit;
