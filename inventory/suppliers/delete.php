<?php
require '../db.php';
session_start();

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM suppliers WHERE supplier_id = ?");
$stmt->execute([$id]);

header("Location: list.php");
exit;
