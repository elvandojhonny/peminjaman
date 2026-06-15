<?php

include 'koneksi.php';

$nama_gedung = $_POST['nama_gedung'] ?? '';
$fakultas    = $_POST['fakultas'] ?? '';

try {

    $stmt = $koneksi->prepare("
        INSERT INTO gedung
        (nama_gedung, fakultas)
        VALUES (?, ?)
    ");

    $stmt->execute([
        $nama_gedung,
        $fakultas
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Gedung berhasil ditambahkan"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}

?>
