<?php

include 'koneksi.php';
include 'auto_update_status.php';

$user_id = $_GET['user_id'] ?? '';

$stmt = $koneksi->prepare("
    SELECT
        p.*,
        g.nama_gedung
    FROM peminjaman p

    LEFT JOIN ruang r
        ON p.nama_ruang = r.nama_ruang

    LEFT JOIN gedung g
        ON r.id_gedung = g.id

    WHERE p.user_id = ?

    ORDER BY p.id DESC
");

$stmt->execute([$user_id]);

$data = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $data[] = [
        "id" => $row['id'],
        "user_id" => $row['user_id'],
        "nama_peminjam" => $row['nama_peminjam'],
        "nama_ruang" => $row['nama_ruang'],
        "nama_gedung" => $row['nama_gedung'],
        "tanggal" => $row['tanggal'],
        "hari" => $row['hari'],
        "jam_mulai" => $row['jam_mulai'],
        "jam_selesai" => $row['jam_selesai'],
        "keterangan" => $row['keterangan'],
        "status" => $row['status'],
        "alasan_ditolak" => $row['alasan_ditolak']
    ];
}

echo json_encode($data);
