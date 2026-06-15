<?php

include 'koneksi.php';
include 'auto_update_status.php';

$stmt = $koneksi->prepare("
    SELECT
        p.*,
        g.fakultas

    FROM peminjaman p

    LEFT JOIN ruang r
        ON p.nama_ruang = r.nama_ruang

    LEFT JOIN gedung g
        ON r.id_gedung = g.id

    ORDER BY p.id DESC
");

$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
