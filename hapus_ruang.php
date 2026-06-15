<?php

include 'koneksi.php';

$id = $_POST['id'] ?? '';

try {

    $stmt = $koneksi->prepare("
        DELETE FROM ruang
        WHERE id = ?
    ");

    $stmt->execute([$id]);

    echo json_encode([
        "success" => true,
        "message" => "Ruang berhasil dihapus"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => "Gagal hapus ruang"
    ]);
}

?>
