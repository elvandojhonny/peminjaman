<?php

include 'koneksi.php';

$data = [];

$stmt = $koneksi->prepare("
    SELECT * FROM gedung
");

$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
