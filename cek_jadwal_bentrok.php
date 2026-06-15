<?php

include 'koneksi.php';

$id = $_POST['id'];
$nama_ruang = $_POST['nama_ruang'];
$tanggal = $_POST['tanggal'];
$jam_mulai = $_POST['jam_mulai'];
$jam_selesai = $_POST['jam_selesai'];

$query = mysqli_query(
    $koneksi,
    "
    SELECT *
    FROM peminjaman
    WHERE

        nama_ruang = '$nama_ruang'

        AND tanggal = '$tanggal'

        AND LOWER(status) IN ('disetujui', 'digunakan')

        AND id != '$id'

        AND (

            ('$jam_mulai' < jam_selesai)

            AND

            ('$jam_selesai' > jam_mulai)

        )

    LIMIT 1
    "
);

if (mysqli_num_rows($query) > 0) {

    $data = mysqli_fetch_assoc($query);

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