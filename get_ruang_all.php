<?php

include 'koneksi.php';

$stmt = $koneksi->prepare("
    SELECT * FROM ruang
");

$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);

?>
