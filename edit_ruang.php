<?php

include 'koneksi.php';

$id         = $_POST['id'] ?? '';
$nama_ruang = $_POST['nama_ruang'] ?? '';
$lokasi     = $_POST['lokasi'] ?? '';
$kapasitas  = $_POST['kapasitas'] ?? '';

try {

    $stmt = $koneksi->prepare("
        UPDATE ruang SET
            nama_ruang = ?,
            lokasi = ?,
            kapasitas = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $nama_ruang,
        $lokasi,
        $kapasitas,
        $id
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Data ruang berhasil diupdate"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
