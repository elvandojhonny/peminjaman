<?php

include 'koneksi.php';

$user_id = $_POST['user_id'] ?? '';
$token   = $_POST['token'] ?? '';

try {

    $stmt = $koneksi->prepare("
        UPDATE users
        SET fcm_token = ?
        WHERE id = ?
    ");

    $stmt->execute([$token, $user_id]);

    echo json_encode([
        "success" => true
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false
    ]);
}

?>
