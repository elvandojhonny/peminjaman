<?php

header("Content-Type: application/json");

include 'koneksi.php';

$id = $_POST['id'] ?? '';

if ($id == '') {

    echo json_encode([
        "success" => false,
        "message" => "ID kosong"
    ]);

    exit;
}

try {

    $stmt = $koneksi->prepare("
        DELETE FROM users
        WHERE id = ?
    ");

    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {

        echo json_encode([
            "success" => true,
            "message" => "User berhasil dihapus"
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "User tidak ditemukan / gagal dihapus"
        ]);
    }

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>
