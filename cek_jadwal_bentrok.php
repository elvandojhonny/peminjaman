<?php

include 'koneksi.php';

$id          = $_POST['id'] ?? '';
$nama_ruang  = $_POST['nama_ruang'] ?? '';
$tanggal     = $_POST['tanggal'] ?? '';
$jam_mulai   = $_POST['jam_mulai'] ?? '';
$jam_selesai = $_POST['jam_selesai'] ?? '';

$stmt = $koneksi->prepare("
    SELECT *
    FROM peminjaman
    WHERE
        nama_ruang = ?
        AND tanggal = ?
        AND LOWER(status) IN ('disetujui', 'digunakan')
        AND id != ?
        AND (
            (? < jam_selesai)
            AND
            (? > jam_mulai)
        )
    LIMIT 1
");

$stmt->execute([
    $nama_ruang,
    $tanggal,
    $id,
    $jam_mulai,
    $jam_selesai
]);

$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($data) {

    echo json_encode([
        "success" => false,
        "message" => "Jadwal bentrok",
        "bentrok" => [
            "nama_peminjam" => $data['nama_peminjam'],
            "nama_ruang" => $data['nama_ruang'],
            "tanggal" => $data['tanggal'],
            "hari" => $data['hari'],
            "jam_mulai" => $data['jam_mulai'],
            "jam_selesai" => $data['jam_selesai'],
            "status" => $data['status']
        ]
    ]);

} else {

    echo json_encode([
        "success" => true,
        "message" => "Jadwal tersedia"
    ]);
}
