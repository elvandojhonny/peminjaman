<?php

include 'koneksi.php';

$id = $_GET['id'] ?? '';

$stmt = $koneksi->prepare("
    SELECT * FROM users
    WHERE id = ?
");

$stmt->execute([$id]);

$data = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($data);
?>
