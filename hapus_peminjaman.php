<?php

include 'koneksi.php';

$id = $_POST['id'] ?? '';

try {

    $stmt = $koneksi->prepare("
        DELETE FROM peminjaman
        WHERE id = ?
    ");

    $stmt->execute([$id]);

    echo json_encode([
        "success" => true,
        "message" => "Riwayat berhasil dihapus"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => "Riwayat gagal dihapus"
    ]);
}

?>
