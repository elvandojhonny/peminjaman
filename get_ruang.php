<?php

include 'koneksi.php';

$id_gedung = $_GET['id_gedung'] ?? '';

$stmt = $koneksi->prepare("
    SELECT * FROM ruang
    WHERE id_gedung = ?
");

$stmt->execute([$id_gedung]);

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
?>
