<?php

include 'koneksi.php';

$id_gedung  = $_POST['id_gedung'] ?? '';
$nama_ruang = $_POST['nama_ruang'] ?? '';
$lokasi     = $_POST['lokasi'] ?? '';
$kapasitas  = $_POST['kapasitas'] ?? '';

try {

    $stmt = $koneksi->prepare("
        INSERT INTO ruang
        (
            id_gedung,
            nama_ruang,
            lokasi,
            kapasitas
        )
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $id_gedung,
        $nama_ruang,
        $lokasi,
        $kapasitas
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Ruang berhasil ditambahkan"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>
