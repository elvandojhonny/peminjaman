<?php

include 'koneksi.php';

try {

    $stmt = $koneksi->prepare("
        DELETE FROM peminjaman
        WHERE CONCAT(tanggal,' ',jam_selesai)
        < DATE_SUB(NOW(), INTERVAL 48 HOUR)
    ");

    $stmt->execute();

    echo json_encode([
        "success" => true
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false
    ]);
}

?>
