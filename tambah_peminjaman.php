<?php

header("Content-Type: application/json");

include 'koneksi.php';

$user_id       = $_POST['user_id'] ?? '';
$nama_peminjam = $_POST['nama_peminjam'] ?? '';
$nama_gedung   = $_POST['nama_gedung'] ?? '';
$nama_ruang    = $_POST['nama_ruang'] ?? '';
$tanggal       = $_POST['tanggal'] ?? '';
$hari          = $_POST['hari'] ?? '';
$jam_mulai     = $_POST['jam_mulai'] ?? '';
$jam_selesai   = $_POST['jam_selesai'] ?? '';
$keterangan    = $_POST['keterangan'] ?? '';

try {

    $stmt = $koneksi->prepare("
        INSERT INTO peminjaman
        (
            user_id,
            nama_peminjam,
            nama_gedung,
            nama_ruang,
            tanggal,
            hari,
            jam_mulai,
            jam_selesai,
            keterangan
        )
        VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $user_id,
        $nama_peminjam,
        $nama_gedung,
        $nama_ruang,
        $tanggal,
        $hari,
        $jam_mulai,
        $jam_selesai,
        $keterangan
    ]);

    try {

        include 'send_notification.php';

        $admin = $koneksi->query("
            SELECT fcm_token
            FROM users
            WHERE role='admin'
            LIMIT 1
        ");

        $dataAdmin = $admin->fetch(PDO::FETCH_ASSOC);

        if (
            $dataAdmin &&
            !empty($dataAdmin['fcm_token'])
        ) {

            $hasilNotif = sendNotification(
                $dataAdmin['fcm_token'],
                "Peminjaman Baru",
                "$nama_peminjam mengajukan kelas $nama_ruang"
            );

        } else {

            $hasilNotif = "TOKEN ADMIN KOSONG";
        }

    } catch (Exception $e) {

        $hasilNotif = $e->getMessage();
    }

    echo json_encode([
        "success" => true,
        "message" => "Kelas berhasil diajukan",
        "debug_notif" => $hasilNotif
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>
