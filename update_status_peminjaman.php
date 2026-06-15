<?php

include 'koneksi.php';
include 'send_notification.php';

$id = $_POST['id'] ?? '';
$status = $_POST['status'] ?? '';
$alasan_ditolak = $_POST['alasan_ditolak'] ?? '';

try {

    // AMBIL DATA PEMINJAMAN

    $get = $koneksi->prepare("
        SELECT *
        FROM peminjaman
        WHERE id = ?
    ");

    $get->execute([$id]);

    $data = $get->fetch(PDO::FETCH_ASSOC);

    if (!$data) {

        echo json_encode([
            "success" => false,
            "message" => "Data peminjaman tidak ditemukan"
        ]);

        exit;
    }

    $nama_ruang  = trim($data['nama_ruang']);
    $tanggal     = trim($data['tanggal']);
    $jam_mulai   = trim($data['jam_mulai']);
    $jam_selesai = trim($data['jam_selesai']);
    $user_id     = trim($data['user_id']);

    // CEK BENTROK

    if (strtolower($status) == "disetujui") {

        $cek = $koneksi->prepare("
            SELECT *
            FROM peminjaman
            WHERE

                id != ?

                AND nama_ruang = ?

                AND tanggal = ?

                AND LOWER(status) IN ('disetujui','digunakan')

                AND (

                    (? < jam_selesai)

                    AND

                    (? > jam_mulai)

                )

            LIMIT 1
        ");

        $cek->execute([
            $id,
            $nama_ruang,
            $tanggal,
            $jam_mulai,
            $jam_selesai
        ]);

        if ($cek->fetch(PDO::FETCH_ASSOC)) {

            echo json_encode([
                "success" => false,
                "message" => "Kelas sedang digunakan pada jam tersebut"
            ]);

            exit;
        }
    }

    // UPDATE STATUS

    $update = $koneksi->prepare("
        UPDATE peminjaman
        SET
            status = ?,
            alasan_ditolak = ?
        WHERE id = ?
    ");

    $update->execute([
        $status,
        $alasan_ditolak,
        $id
    ]);

    // AMBIL TOKEN USER

    $getUser = $koneksi->prepare("
        SELECT fcm_token
        FROM users
        WHERE id = ?
    ");

    $getUser->execute([$user_id]);

    $user = $getUser->fetch(PDO::FETCH_ASSOC);

    if (
        isset($user['fcm_token']) &&
        !empty($user['fcm_token'])
    ) {

        $title = "Status Peminjaman";

        if ($status == "Disetujui") {

            $body =
                $nama_ruang .
                " berhasil disetujui";

        } else {

            $body =
                $nama_ruang .
                " ditolak. Alasan: " .
                $alasan_ditolak;
        }

        sendNotification(
            $user['fcm_token'],
            $title,
            $body
        );
    }

    echo json_encode([
        "success" => true,
        "message" => "Status berhasil diupdate"
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>
